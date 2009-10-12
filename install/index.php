<?php
/**
 * @file
 * Install script for Studentware.
 */
include('../config.php');
include('../functions/functions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">

<head>
	<title>Studentware Installer</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" media="screen" href="style.css">
</head>

<body>
<h1>Studentware Installer</h1>
<form action="." method="post">
	<fieldset>
		<legend>Setup admin account</legend>
		<label for="email">Email</label>
		<input name="email" type="text" id="email">
		 (this is also your login name)<br>
		<label for="pass">Password</label>
		<input name="pass" type="password" id="pass"><br>
		<input name="install" type="submit" value="Install">
	</fieldset>
</form>
<pre>

<?php

$input_data = array (
	'email' => FILTER_VALIDATE_EMAIL,
	'pass' => FILTER_REQUIRE_ARRAY,
	'install' => FILTER_REQUIRE_ARRAY
);
$filtered_data = filter_input_array(INPUT_POST, $input_data);

if (
	$filtered_data['email'] &&
	$filtered_data['pass'] &&
	$filtered_data['install']
) {

echo 'Installing...' . "\n";

$files = scandir('.');

foreach($files as $file) {
	if(preg_match('/\.sql$/i', $file)) {
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
		if($file == '0-init.sql') {
			$query = 'insert into users values (
				1, 1, "Admin", " ",
				"'.$filtered_data['email'].'",
				"'.sha1($filtered_data['pass']).'", null
			);';
			mysql_query($query);
		}
	}
}
?>
DONE

Delete the install folder!

<a href="../">Go to Studentware</a>

<?php
} // end if
?>
</pre>
</body>
</html>
