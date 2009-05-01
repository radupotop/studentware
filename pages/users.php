<?php
/**
 * @file
 * Users and its configuration.
 */

if ($_SESSION['login']) {

	$html_filter = new InputFilter($tags['forum']);

	Action::users_add();
	Action::users_edit();
	Action::users_delete();
?>
<div id="users">

<h2>Groups</h2>
<?php
	View::groups();
	View::users();
?>

</div>
<?php
} else {
	header('Location: .');
}
?>
