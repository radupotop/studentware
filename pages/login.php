<div id="login">
	<h2 class="hidden">Login</h2>

<?php
if ($_SESSION['login']) {
?>

<form action="<?php echo current_page('escape'); ?>" method="post">
	<div>
		Hello <strong><?php echo $_SESSION['first_name'] . ' '
			. $_SESSION['fam_name']; ?></strong>
		<input name="logout" type="submit" value="Logout">
	</div>
</form>

<?php
$logout = $_POST['logout'];

if ($logout) {
	session_destroy();
	setcookie(session_name(), '', 0, '/');
	header('Location: ' . current_page());
}
} else {
?>

<form action="<?php echo current_page('escape'); ?>" method="post">
	<div>
		<label for="email">Email</label>
		<input name="email" type="text" id="email">
		<label for="pass">Password</label>
		<input name="pass" type="password" id="pass">
		<input name="login" type="submit" value="Login">

<?php
$email = $_POST['email'];
$pass = $_POST['pass'];
$login = $_POST['login'];

if ($login) {
	$pass = sha1($pass);
	$result = mysql_query('
		select * from users
		where email = "' . $email . '" and pass = "' . $pass . '"
	');
	$row = mysql_fetch_array($result);
	if ($row) {
		$_SESSION['login'] = true;
		$_SESSION['id_user'] = $row['id_user'];
		$_SESSION['id_group'] = $row['id_group'];
		$_SESSION['first_name'] = $row['first_name'];
		$_SESSION['fam_name'] = $row['fam_name'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['pass'] = $row['pass'];
		$_SESSION['about'] = $row['about'];
		header('Location: ' . current_page());
	} else {
		unset($email, $pass, $login);
		echo '		<span class="error">Login incorrect</span>';
	}
}
?>

	</div>
</form>

<?php
}
?>
</div>
