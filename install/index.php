<?php
/**
 * @file
 * Install script for Studentware.
 */
header('Content-type: text/plain');

echo 'Installing...' . "\n";

include('../config.php');
include('../functions/functions.php');

$files = scandir('.');

foreach($files as $file) {
	if(eregi('.sql$', $file)) {
		echo '	' . $file . "\n";
		$file_content = file_get_contents($file);
		$sql = explode(';', $file_content);
		foreach($sql as $query) {
			mysql_query($query);
			if(mysql_errno() && mysql_errno() != 1065) {
				echo
				'		Error ' . mysql_errno() . ': ' . mysql_error() ."\n";
			}
		}
	}
}

echo 'DONE';
?>
