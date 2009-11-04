<?php
/**
 * @file
 * Jobs to be executed by cron.
 */
include('../config.php');
include('functions.php');

// mailing list

$mail = new MailingList (
	$mailing_list['email'],
	$mailing_list['mbox']['server'],
	$mailing_list['mbox']['param'],
	$mailing_list['user'],
	$mailing_list['pass']
);

$mail->dist();
$mail->delete();

?>
