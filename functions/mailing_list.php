<?php
/**
 * @file
 * Simple mailing list for Studentware.
 */
include('../config.php');
include('functions.php');

function mailing_list() {
	global $mailing_list;
	if($mailing_list['enabled']==false) return(false);

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

		$content_type = 'Content-Type: text/html';
/*
		// Yahoo hack
		if($from->host == 'yahoo.com') {
			$content_type = 'Content-Type: multipart/alternative; boundary="0-1953086045-1254883701=:64565"';
		}
*/

		foreach($emails as $email) {
			// Send to all except original sender
			if ($email != $from_email) {
				imap_mail($email, $subject, $body, $content_type);
			}
		}

	}


	// Close connection
	imap_close($conn);
	return(true);
}
mailing_list();
?>
