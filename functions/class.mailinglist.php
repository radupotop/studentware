<?php
/**
 * Mailing list. Send emails to registered users.
 * @class MailingList
 */

class MailingList {
	private $conn;

	/**
	 * Connect to server.
	 */
	function __construct() {
		global $mailing_list;

		$this->conn = imap_open (
			'{'.$mailing_list['server'].$mailing_list['param'].'}Inbox',
			$mailing_list['user'],
			$mailing_list['pass']
		);
		if ($this->conn) _log('ml: logged in');
	}

	/**
	 * Get email addresses of registered users.
	 * @return array $emails
	 */
	function addrArray() {
		$result = mysql_query('select email from users');
		queryCount();
		$num_rows = mysql_num_rows($result);
		for($i=0; $i<$num_rows ;$i++) {
			$row = mysql_fetch_array($result);
			$emails[$i] = $row[0];
		}
		return $emails;
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
			$body = preg_replace('/\n.*\n.*\n[>]+.*/', '', $body);

			// Get messages only from registered users.
			$emails = $this->addrArray();
			if(in_array($from_email, $emails)) {
				$messages[$i] = array (
					'from' => $from_email,
					'subject' => $subject,
					'body' => $body
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
		global $mailing_list;

		$addr = $this->addrArray();
		$msg = $this->msgArray();

		if ($addr && $msg)
			foreach($addr as $address)
				foreach ($msg as $message)
					if (
						$address != $message['from'] &&
						$address != $mailing_list['email']
					) {
						$this->send(
							$address,
							$message['subject'],
							strip_tags($message['body'])
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
	function send($to, $subject, $body, $headers=null) {
		global $mailing_list;

		if(!$headers) {
		$headers  =
			'From: '. $mailing_list['email'] . "\r\n".
			'Reply-To: '. $mailing_list['email'];
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
