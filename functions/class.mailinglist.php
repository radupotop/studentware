<?php
/**
 * Send emails to registered users, post to forum.
 * @class MailingList
 */
include('../config.php');
include('functions.php');

class MailingList {

	/**
	 * Connect to server.
	 */
	function __construct() {
		global $mailing_list, $conn;

		$conn = imap_open (
			'{'.$mailing_list['server'].$mailing_list['param'].'}Inbox',
			$mailing_list['user'],
			$mailing_list['pass']
		);
		if ($conn) _log('ml: logged in');
	}

	/**
	 * Get email addresses of registered users.
	 * @return array $emails
	 */
	function addrArray() {
		$result = mysql_query('select email from users');
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
		global $conn;

		$headers = imap_headers($conn);
		$num_emails = sizeof($headers);

		_log('ml: '.$num_emails.' messages in total');

		for ($i = 1; $i < $num_emails+1; $i++) {
			$mail_header = imap_headerinfo($conn, $i);

			// $from is an object
			$from = $mail_header->from[0];
			$from_email = $from->mailbox.'@'.$from->host;

			$subject = esc($mail_header->subject);
			$subject = preg_replace('/^[Re: ?]+/i', '', $subject);

			$body = strip_tags(imap_body($conn, $i));
			$body = preg_replace('/\n.*\n.*\n[>]+.*/', '', $body);

			$emails = $this->addrArray();

			// Get messages only from registered users.
			if(in_array($from_email, $emails)) :
				$messages[$i] = array (
					'from' => $from_email,
					'subject' => $subject,
					'body' => $body
				);
			endif;
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
				foreach ($msg as $message) {
					if(
						$address != $message['from'] &&
						$address != $mailing_list['email']
					)
						$this->send(
							$address, $message['subject'], $message['body']
						);
					/**
					 * makeTopic, makePost
					 *
					 * makeTopic($from_email, $subject);
					 * @return id_topic ?
					 *
					 * makePost($id_topic, $id_user, $body);
					 */
				}
		return;
	}

	/**
	 * Send one email.
	 *
	 * @param string $to
	 * @param string $subject
	 * @param string $body
	 * @param string $headers
	 */
	function send($to, $subject, $body, $headers = null) {
		$send = imap_mail($to, $subject, $body, $headers);
		if ($send)
			_log('ml: sent '.$subject.' to '.$to);
		return;
	}


	/**
	 * Expunge emails and close connection.
	 */
	function __destruct() {
		global $conn;

		if (imap_delete($conn,'1:*')) _log('ml: deleted all messages');
		if (imap_expunge($conn)) _log('ml: expunged');
		if (imap_close($conn)) _log('ml: closed');
	}
}
$mail = new MailingList();
$msg = $mail->massSend();
//var_dump($msg);
?>
