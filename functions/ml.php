<?php
function mailingList() {
	global $mailing_list;

	$mlRead = new mlRead (
		$mailing_list['email'],
		$mailing_list['mbox']['server'],
		$mailing_list['mbox']['param'],
		$mailing_list['user'],
		$mailing_list['pass']
	);

	$mlSend = new mlSend (
		$mailing_list['email'],
		$mailing_list['smtp']['server'],
		$mailing_list['smtp']['port'],
		$mailing_list['smtp']['crypto'],
		$mailing_list['user'],
		$mailing_list['pass']
	);

	$addrArray = $mlRead->addrArray();
	$msgArray = $mlRead->msgArray();

	$mlSend->dist($addrArray, $msgArray);

	$mlRead->delete();
	return;
}
?>
