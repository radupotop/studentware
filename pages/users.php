<?php
/**
 * @file
 * Users and its configuration.
 */
	$html_filter = new InputFilter($tags['forum']);
?>
<div id="users">

<h2>Groups</h2>
<?php
	View::groups();
	include('users_users.php');
?>

</div>
