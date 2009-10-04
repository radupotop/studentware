<?php
/**
 * @file
 * Simple mailing list for Studentware.
 */
include('../config.php');
include('functions.php');

function mailing_list() {
	global $mailing_list;

	// Connect to IMAP
	$conn = imap_open (
		'{'.$mailing_list['server'].$mailing_list['param'].'}Inbox',
		$mailing_list['user'],
		$mailing_list['pass']
	);


	$headers = imap_headers($conn);
	$numEmails = sizeof($headers);

	for ($i = 1; $i < $numEmails+1; $i++) {
		$mailHeader = imap_headerinfo($conn, $i);
		$from = $mailHeader->fromaddress;
		$subject = $mailHeader->subject;
		$date = $mailHeader->date;

		echo "Email from $from, subject $subject, date $date";
		echo "\n";

		echo imap_body($conn, $i);
		echo "\n";
	}


	// Close connection
	imap_close($conn);
	return;
}
mailing_list();
?>
