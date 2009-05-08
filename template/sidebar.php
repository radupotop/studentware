<?php
/**
 * @file
 * Sidebar template.
 */
?>
</div>

<div id="sidebar">

<h2 class="hidden">Menu</h2>
<?php
/**
 * Display menu.
 * @return null
 */
function display_menu() {
?>
<ul id="menu">
	<li><a href=".">Home</a></li>
	<li><a href="?page=pages">Pages</a></li>
	<li><a href="?page=forum">Forum</a></li>
	<li><a href="?page=files">Files</a></li>
	<li><a href="?page=schedule">Schedule</a></li>
	<li><a href="?page=calendar">Calendar</a></li>

	<?php if ($_SESSION['login']) { ?>
	<li><a href="?page=users">Users</a></li>
	<?php } ?>
</ul>
<?php
	return;
}
display_menu();
?>

<h2 class="hidden">Login</h2>
<div id="login">
<?php
global $login_fail;

/**
 * Display login.
 * @return null
 */
function display_login() {
		global $login_fail;
		if ($_SESSION['login']==false) {
?>
<form action="<?php echo current_page(true); ?>" method="post">
	<div>
		<label for="email">Email</label>
		<input name="email" type="text" id="email">
		<label for="pass">Password</label>
		<input name="pass" type="password" id="pass">
		<input name="login" type="submit" value="Login">
<?php if ($login_fail) { ?>
		<span class="error">Login incorrect</span>
<?php } ?>
	</div>
</form>
<?php
		}
	return;
}
display_login();

/**
 * Display logout.
 * @return null
 */
function display_logout() {
		if ($_SESSION['login']) {
?>
		<form action="<?php echo current_page(true); ?>" method="post">
			<div>
				Hello <strong><?php echo $_SESSION['first_name'] . ' '
				. $_SESSION['fam_name']; ?></strong>
				<input name="logout" type="submit" value="Logout">
			</div>
		</form>
<?php
		}
	return;
}
display_logout();
?>
</div>

</div>