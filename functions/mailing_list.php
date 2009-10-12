<?php
/**
 * @file
 * Simple mailing list for Studentware.
 */
include('../config.php');
include('functions.php');

/**
 * Send emails to all users
 * @param null
 * @return null
 */
function mailing_list() {
	global $mailing_list;

	// Connect to IMAP
	$conn = imap_open (
		'{'.$mailing_list['server'].$mailing_list['param'].'}Inbox',
		$mailing_list['user'],
		$mailing_list['pass']
	);

	// Put all emails in an array
	$result = mysql_query('select email from users');
	$num_rows = mysql_num_rows($result);
	for($i=0; $i<$num_rows ;$i++) {
		$row = mysql_fetch_array($result);
		$emails[$i] = $row[0];
	}

	// Email all users
	$headers = imap_headers($conn);
	$num_emails = sizeof($headers);

	for ($i = 1; $i < $num_emails+1; $i++) {
		$mail_header = imap_headerinfo($conn, $i);
		// $from is an object
		$from = $mail_header->from[0];
		$subject = $mail_header->subject;
		$body = imap_body($conn, $i);

		$from_email = $from->mailbox.'@'.$from->host;

		foreach($emails as $email) {
			// Send to all except original sender
			if ($email != $from_email) {
				imap_mail($email, $subject, strip_tags($body));
			}
		}

	}

	// Close connection
	imap_close($conn);
	return;
}

if ($mailing_list['enabled']) {
	mailing_list();
}
?>
