<?php
/**
 * Read & process emails from mailbox.
 * @class mlRead
 */

class mlRead {
	public $mlEmail;
	public $server;
	public $param;
	public $user;
	public $pass;

	private $conn;

	/**
	 * Connect to server.
	 *
	 * @param string $mlEmail - mailing list email address
	 * @param string $server
	 * @param string $param - connection parameters, eg: '/imap/ssl/'
	 * @param string $user
	 * @param string $pass
	 */
	function __construct($mlEmail, $server, $param, $user, $pass) {
		$this->mlEmail = $mlEmail;
		$this->server = $server;
		$this->param = $param;
		$this->user = $user;
		$this->pass = $pass;

		$this->conn = imap_open (
			'{'.$this->server.$this->param.'}Inbox', $this->user, $this->pass
		);
		if ($this->conn) _log('ml: logged in');
	}

	/**
	 * Get email addresses of registered users.
	 * The array keys are the user IDs.
	 * @return array $addresses
	 */
	function addrArray() {
		$result = mysql_query('select * from users');
		queryCount();
		$numRows = mysql_num_rows($result);
		for($i=0; $i<$numRows; $i++) {
			$row = mysql_fetch_array($result);
			$addresses[$row['id_user']] = $row['email'];
		}
		return $addresses;
	}

	/**
	 * Get messages.
	 * The email bodies are left intact (even if they're multipart).
	 * Headers will contain: content-type, boundary, from
	 * @return array $messages
	 */
	function msgArray() {
		$imap_headers = imap_headers($this->conn);
		$num_emails = sizeof($imap_headers);

		_log('ml: '.$num_emails.' messages in total');

		for ($i = 1; $i < $num_emails+1; $i++) {
			$headerInfo = imap_headerinfo($this->conn, $i);

			// $from is an object
			$from = $headerInfo->from[0];
			$fromName = $from->personal;
			$fromEmail = $from->mailbox.'@'.$from->host;
			$subject = $headerInfo->subject;
			$body = imap_body($this->conn, $i);

			$struct = imap_fetchstructure($this->conn, $i);

			// from imap_fetchstructure() manual:
			$typeArray = array (
				0 => 'TEXT',
				1 => 'MULTIPART',
				2 => 'MESSAGE',
				3 => 'APPLICATION',
				4 => 'AUDIO',
				5 => 'IMAGE',
				6 => 'VIDEO',
				7 => 'OTHER'
			);
			$encodingArray = array (
				0 => '7BIT',
				1 => '8BIT',
				2 => 'BINARY',
				3 => 'BASE64',
				4 => 'QUOTED-PRINTABLE',
				5 => 'OTHER'
			);

			// get message type
			foreach($typeArray as $key => $value) {
				if($key == $struct->type) {
					$type = $value;
					break;
				}
			}
			// get message subtype
			$subtype = $struct->subtype;
			// get message encoding
			foreach($encodingArray as $key => $value) {
				if($key == $struct->encoding) {
					$encoding = $value;
					break;
				}
			}
			// get boundary, charset
			$parameters = $struct->parameters;
			foreach($parameters as $param) {
				if($param->attribute == 'boundary')
					$boundary = $param->value;
				if($param->attribute == 'charset')
					$charset = $param->value;
			}
			if($boundary)
				$boundaryString = 'boundary="'.$boundary.'"; ';
			if($charset)
				$charsetString = 'charset='.$charset.'; ';

			// compose headers
			global $app, $site;
			$headers =
				'X-Mailer: Studentware '.$app['ver']."\r\n".
				'From: '.$fromName.' <'.$fromEmail.'>'."\r\n".
				'To: '.$site['name'].' <'.$this->mlEmail.'>'."\r\n".
				'Reply-To: '.$site['name'].' <'.$this->mlEmail.'>'."\r\n".
				'MIME-Version: 1.0'."\r\n".
				'Content-Type: '.$type.'/'.$subtype.'; '.
					$charsetString . $boundaryString."\r\n".
				'Content-Transfer-Encoding: '.$encoding."\r\n"
			;

			// Get messages only from subscribed users
			if (in_array($fromEmail, $this->addrArray())) {
				$messages[$i] = array (
					'from' => $fromEmail,
					'subject' => $subject,
					'body' => $body,
					'headers' => $headers
				);
			}
		}
		_log('ml: '.count($messages).' messages from registered users');
		return $messages;
	}

	/**
	 * Parse message to forum post.
	 * @return array $post
	 */
	function msgToPost() {
		$imapHeaders = imap_headers($this->conn);
		$numEmails = count($imapHeaders);

		for ($i=1; $i<$numEmails+1; $i++) {
			$headerInfo = imap_headerinfo($this->conn, $i);
			$title = $headerInfo->subject;

			if(!preg_match('/\[NOPOST]/', $title)) {
				$post[$i]['title'] = $title;
				$post[$i]['title'] =
					str_replace('[NOMAIL] ', null, $post[$i]['title']);
				$post[$i]['title'] =
					preg_replace('/^[Re: ?]+/i', null, $post[$i]['title']);

				$struct = imap_fetchstructure($this->conn, $i);
				// text/*
				if($struct->type === 0) {
					$post[$i]['body'] = imap_fetchbody($this->conn, $i, 1);
					$post[$i]['body'] =
						$this->decode($post[$i]['body'], $struct->encoding);
					$post[$i]['body'] =
						$this->filterBody($post[$i]['body'], $struct->subtype);
				}
				// multipart/*
				if($struct->type === 1) {
					if($struct->subtype == 'ALTERNATIVE') {
						$post[$i]['body'] = imap_fetchbody($this->conn, $i, 2);
						$struct = $struct->parts[1];
						$post[$i]['body'] =
							$this->decode($post[$i]['body'], $struct->encoding);
						$post[$i]['body'] =
							$this->filterBody($post[$i]['body'], 'html');
					}
					if($struct->subtype == 'MIXED') {
						$struct = $struct->parts[0];
						// text/*
						if($struct->type === 0) {
							$post[$i]['body'] = imap_fetchbody($this->conn, $i, 1);
							$post[$i]['body'] =
								$this->decode($post[$i]['body'], $struct->encoding);
							$post[$i]['body'] =
								$this->filterBody($post[$i]['body'], $struct->subtype);
						}
						// multipart/*
						if($struct->type === 1)
							if($struct->subtype == 'ALTERNATIVE') {
								$post[$i]['body'] = imap_fetchbody($this->conn, $i, 1.2);
								$struct = $struct->parts[1];
								$post[$i]['body'] =
									$this->decode($post[$i]['body'], $struct->encoding);
								$post[$i]['body'] =
									$this->filterBody($post[$i]['body'], 'html');
							}
					}
				}
				$post[$i]['body'] = trim($post[$i]['body']);

				// $from is an object
				$from = $headerInfo->from[0];
				$fromEmail = $from->mailbox.'@'.$from->host;
				$post[$i]['id_user'] =
					array_search($fromEmail, $this->addrArray());

				// unset post if one of the values is null
				foreach($post[$i] as $value)
					if (!$value)
						unset($post[$i]);
			}
			// end post
		}
		return $post;
	}

	/**
	 * Decode MIME encoded body.
	 *
	 * @param string $body
	 * @param int $encoding
	 * @return string $body
	 */
	function decode($body, $encoding=int) {
		// transfer encoding codes are found in imap_fetchstructure manual page
		switch($encoding) {
			case 0:
			case 1:
				// body is 7bit or 8bit, no decoding.
				break;
			case 3:
				// decode base64
				$body = base64_decode($body);
				break;
			case 4:
				// decode quoted printable
				$body = quoted_printable_decode($body);
				break;
			default:
				$body = null;
		}
		return $body;
	}

	/**
	 * Filter post body.
	 *
	 * @param string $body
	 * @param string @subtype - plain or html
	 * @return string $body
	 */
	function filterBody($body, $subtype) {
		switch(strtolower($subtype)) {
			case 'plain':
				// strip quoted messages
				$body = preg_replace('/(\n.*){1,2}(\n ?>.*)+(\n.*)+/', null, $body);
				$body = trim($body);
				$body = str_replace("\n", "<br>\n", $body);
				break;
			case 'html':
				global $tags, $attr;
				// filter html
				$htmlFilter = new InputFilter($tags, $attr);
				$body = $htmlFilter->process($body);
				// strip blockquoted messages
				$body = preg_replace('/(<\/span>.*)?(<div.*)?(<br.*)?(\n.*){0,2}(<blockquote.*)(\n.*)+/', null, $body);
				$body = trim($body);
				break;
			default:
				$body = null;
		}
		return $body;
	}

	/**
	 * Internal send, eg: from forum to ml.
	 *
	 * @param string $userName - name of sender
	 * @param string $email - email of sender
	 * @param string $subject
	 * @param string $body
	 * @param string $tag - optional, can be: nopost, nomail, null
	 */
	function internal($userName, $email, $subject, $body, $tag=null) {
		global $app;

		$boundary = 'Studentware-'.sha1(time() + rand());
		$headers =
			'X-Mailer: Studentware '.$app['ver']."\r\n".
			'From: '.$userName.' <'.$email.'>'."\r\n".
			'To: '.$this->mlEmail."\r\n".
			'MIME-Version: 1.0'."\r\n".
			'Content-Type: multipart/alternative; boundary="'.$boundary.'"'.
			"\r\n".
			"\r\n"
		;

		$body =
			'--'.$boundary."\r\n".
			'Content-Type: text/plain; charset=utf-8'."\r\n".
			"\r\n".
			strip_tags($body)."\r\n".
			'--'.$boundary."\r\n".
			'Content-Type: text/html; charset=utf-8'."\r\n".
			"\r\n".
			$body."\r\n".
			'--'.$boundary.'--'."\r\n"
		;

		$tag = strtolower(trim($tag));
		switch($tag) {
			case 'nopost':
				$tag = '[NOPOST] ';
				break;
			case 'nomail':
				$tag = '[NOMAIL] ';
				break;
			default:
				$tag = null;
				break;
		}
		$subject = 'Subject: '.$tag.$subject."\r\n";

		$message = $subject.$headers.$body;

		$status = imap_append (
			$this->conn, '{'.$this->server.$this->param.'}Inbox', $message
		);
		return $status;
	}

	/**
	 * Delete emails.
	 * @param string $msgNo - message no. to delete, or null to delete all
	 */
	function delete($msgNo = '1:*') {
		if (imap_delete($this->conn, $msgNo))
			_log('ml: deleted message='.$msgNo);
		return;
	}

	/**
	 * Expunge emails and close connection.
	 */
	function __destruct() {
		if (imap_expunge($this->conn)) _log('ml: expunged');
		if (imap_close($this->conn)) _log('ml: closed');
	}

}
?>
