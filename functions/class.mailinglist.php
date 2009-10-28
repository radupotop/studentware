<?php
/**
 * Mailing list. Send emails to registered users.
 * @class MailingList
 */

class MailingList {
	public $email;
	public $server;
	public $param;
	public $user;
	public $pass;

	private $conn;

	/**
	 * Connect to server.
	 *
	 * @param string $email - email address of mailing list
	 * @param string $server
	 * @param string $param - imap parameters, eg: '/imap/ssl'
	 * @param string $user
	 * @param string $pass
	 */
	function __construct($email, $server, $param, $user, $pass) {
		$this->email = $email;
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
	 * @return array $messages
	 */
	function msgArray() {
		$headers = imap_headers($this->conn);
		$num_emails = sizeof($headers);

		_log('ml: '.$num_emails.' messages in total');

		for ($i = 1; $i < $num_emails+1; $i++) {
			$mail_header = imap_headerinfo($this->conn, $i);

			// $from is an object
			$from = $mail_header->from[0];
			$from_email = $from->mailbox.'@'.$from->host;
			$subject = $mail_header->subject;
			$body = imap_body($this->conn, $i);

			// get content-type (and boundary) line:
			$full_headers=imap_fetchheader($this->conn, $i);
			preg_match('/\nContent-Type.*/i', $full_headers, $match);
			$content_type = trim($match[0]);

			// Get messages only from registered users.
			$emails = $this->addrArray();
			if(in_array($from_email, $emails)) {
				$messages[$i] = array (
					'from' => $from_email,
					'subject' => $subject,
					'body' => $body,
					'headers' => $content_type
				);
			}
		}
		_log('ml: '.count($messages).' messages from registered users');
		return $messages;
	}

	/**
	 * Send messages to all users.
	 */
	function massSend() {
		$addr = $this->addrArray();
		$msg = $this->msgArray();

		if ($addr && $msg)
			foreach($addr as $address)
				foreach ($msg as $message)
					if (
						$address != $message['from'] &&
						$address != $this->email
					) {
						$this->send(
							$address,
							$message['subject'],
							$message['body'],
							$message['headers']
						);
					}
		return;
	}

	/**
	 * Send one email.
	 *
	 * @param string $to
	 * @param string $subject
	 * @param string $body
	 */
	function send($to, $subject, $body, $headers) {
		global $app, $site;

		$external = preg_match('/\nContent-Type.*/i', $headers);

		if ($external) {
			$headers =
				'X-Mailer: Studentware '.$app['ver']."\n".
				'From: '.$site['name'].' <'.$this->email.'>'.
				'Reply-To: '.$site['name'].' <'.$this->email.'>'."\n".
				'MIME-Version: 1.0'."\n".
				$headers."\n"
			;
		} else {
			$boundary = 'Studentware-'.md5(time());
			$headers  =
				'X-Mailer: Studentware '.$app['ver']."\n".
				$headers."\n".
				'MIME-Version: 1.0'."\n".
				'Content-Type: multipart/alternative; boundary="'.$boundary.'"'.
				"\n"
			;
			$body =
				'--'.$boundary."\n".
				'Content-Type: text/plain; charset=utf-8'."\n".
				"\n".
				strip_tags($body)."\n".
				'--'.$boundary."\n".
				'Content-Type: text/html; charset=utf-8'."\n".
				"\n".
				$body."\n".
				'--'.$boundary.'--'."\n"
			;
		}

		$send = imap_mail($to, $subject, $body, $headers);
		if ($send)
			_log('ml: sent '.$subject.' to '.$to);
		return;
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
