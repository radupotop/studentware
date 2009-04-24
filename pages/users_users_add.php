<form action="?page=users" method="post">
	<div>
		<select title="Group" name="id_group" id="id_group">
			<option value="1">Admin</option>
			<option value="2">Teacher</option>
			<option value="3" selected="selected">Student</option>
		</select>
		<input title="First name" name="first_name" type="text" id="first_name">
		<input title="Family name" name="fam_name" type="text" id="fam_name">
		<input title="Email" name="email" type="text" id="email">
		<input title="Password" name="pass" type="password" id="pass">
		<input title="About" name="about" id="about">
		<input name="create_user" type="submit" value="Create user">
	</div>
</form>

<?php
$id_group = $_POST['id_group'];
$first_name = $_POST['first_name'];
$fam_name = $_POST['fam_name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$about = $_POST['about'];
$create_user = $_POST['create_user'];

if ($create_user) {
	$pass = sha1($pass);
	mysql_query('
		insert into users values (null, ' . $id_group . ', "' . $first_name .
		'", "' . $fam_name . '", "' . $email . '", "' . $pass . '", "' .
		$about . '")
	');
	header('Location: ?page=users');
}
