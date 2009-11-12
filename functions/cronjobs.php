<?php
/**
 * @file
 * Jobs to be executed by cron.
 */

// mailing list
if ($mailing_list['enabled']) {
	include('functions/ml.php');
	mailingList();
}

?>
