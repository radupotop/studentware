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
	 * @return array $addresses
	 */
	function addrArray() {
		$result = mysql_query('select email from users');
		queryCount();
		$num_rows = mysql_num_rows($result);
		for($i=0; $i<$num_rows ;$i++) {
			$row = mysql_fetch_array($result);
			$addresses[$i] = $row[0];
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
			$mail_header = imap_headerinfo($this->conn, $i);

			// $from is an object
			$from = $mail_header->from[0];
			$fromName = $from->personal;
			$from_email = $from->mailbox.'@'.$from->host;
			$subject = $mail_header->subject;
			$body = imap_body($this->conn, $i);

			// get content-type (and boundary) line:
			$fullHeaders=imap_fetchheader($this->conn, $i);
			preg_match('/\nContent-Type.*/i', $fullHeaders, $match1);
			preg_match('/.*boundary.*/i', $fullHeaders, $match2);
			$content_type = trim($match1[0]);
			$boundary = trim($match2[0]);

			global $app, $site;
			$headers =
				'X-Mailer: Studentware '.$app['ver']."\r\n".
				'From: '.$fromName.' <'.$from_email.'>'."\r\n".
				'To: '.$site['name'].' <'.$this->mlEmail.'>'."\r\n".
				'Reply-To: '.$site['name'].' <'.$this->mlEmail.'>'."\r\n".
				'MIME-Version: 1.0'."\r\n"
			;

			if ($content_type)
				$headers .= $content_type . "\r\n";
			if ($boundary && $content_type != $boundary)
				$headers .= ' '.$boundary . "\r\n";

			// Get messages only from subscribed users or from ml email address
			$allowedEmails = $this->addrArray();
			if (
				in_array($from_email, $allowedEmails) ||
				$from_email == $this->mlEmail
			) {
				$messages[$i] = array (
					'from' => $from_email,
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
						$this->filterBody($post[$i]['body'], $struct->subtype);
				}
				// multipart/*
				if($struct->type === 1) {
					if($struct->subtype == 'ALTERNATIVE') {
						$post[$i]['body'] = imap_fetchbody($this->conn, $i, 2);
						$post[$i]['body'] =
							$this->filterBody($post[$i]['body'], 'html');
					}
					if($struct->subtype == 'MIXED') {
						$struct = $struct->parts[0];
						// text/*
						if($struct->type === 0) {
							$post[$i]['body'] = imap_fetchbody($this->conn, $i, 1);
							$post[$i]['body'] =
								$this->filterBody($post[$i]['body'], $struct->subtype);
						}
						// multipart/*
						if($struct->type === 1)
							if($struct->subtype == 'ALTERNATIVE') {
								$post[$i]['body'] = imap_fetchbody($this->conn, $i, 1.2);
								$post[$i]['body'] =
									$this->filterBody($post[$i]['body'], 'html');
							}
					}
				}
			}
			// end msg
		}
		return $post;
	}


	function filterBody($body, $subtype) {
		$subtype == strtolower(trim($subtype));
		switch($subtype) {
			case 'plain':
				$body = preg_replace('/\n.*\n.*\n[>]+.*/', null, $body);
				$body = str_replace("\n", "<br>\n", $body);
				break;
			case 'html':
				break;
			default:
				$body = false;
		}
		return $body;
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
