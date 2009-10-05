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
	sort($emails);

	$headers = imap_headers($conn);
	$num_emails = sizeof($headers);

	for ($i = 1; $i < $num_emails+1; $i++) {
		$mail_header = imap_headerinfo($conn, $i);

/*
		$from = $mail_header->fromaddress;
		$subject = $mail_header->subject;
		$date = $mail_header->date;

		echo "Email from $from, subject $subject, date $date";
		echo "\n";

		echo imap_body($conn, $i);
*/
	}


	// Close connection
	imap_close($conn);
	return(true);
}
mailing_list();
?>
