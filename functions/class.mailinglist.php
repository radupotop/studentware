<?php
/**
 * Send emails to subscribed users.
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
	 * The email bodies are left intact (even if they're multipart).
	 * Headers will contain content-type and boundary.
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
			$from_email = $from->mailbox.'@'.$from->host;
			$subject = $mail_header->subject;
			$body = imap_body($this->conn, $i);

			// get content-type (and boundary) line:
			$fullHeaders=imap_fetchheader($this->conn, $i);
			preg_match('/.*Content-Type.*/i', $fullHeaders, $match1);
			preg_match('/.*boundary.*/i', $fullHeaders, $match2);
			$content_type = trim($match1[0]);
			$boundary = trim($match2[0]);

			$headers .= $content_type . "\r\n";
			if ($boundary && $content_type != $boundary)
				$headers .= $boundary . "\r\n";

			// Get messages only from subscribed users or from ml email address
			$allowedEmails = $this->addrArray();
			if (
				in_array($from_email, $allowedEmails) ||
				$from_email == $this->email
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
	 * Distribute:
	 * Sends emails to ml subscribers.
	 */
	function dist() {
		global $mailing_list;
		$mail = new Smtp(
			$mailing_list['smtp']['server'],
			$mailing_list['smtp']['port'],
			$mailing_list['smtp']['crypto'],
			$mailing_list['user'],
			$mailing_list['pass']
		);

		$addr = $this->addrArray();
		$msg = $this->msgArray();

		if($addr && $msg)
			foreach ($addr as $address)
				foreach ($msg as $message)
					if (
						// do not resend to original sender or to ml
						$address != $message['from'] &&
						$address != $this->email
					) {
						$mail->send(
							$this->email,
							$address,
							$message['subject'],
							$message['body'],
							$headers
						);
					}
		unset($mail);
		return;
	}

	/**
	 * Template for dist() headers
	 * @return string $headers
	 */
	function distHeaders() {
		global $app;
		$headers =
			'X-Mailer: Studentware '.$app['ver']."\r\n".
			'From: '.$this->email."\r\n".
			'Reply-To: '.$this->email."\r\n".
			'MIME-Version: 1.0'."\r\n"
		;
		return $headers;
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
