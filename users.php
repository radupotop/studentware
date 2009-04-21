<?php
// create, edit, delete users
if ($_SESSION['login']) {
?>

<h2>Users</h2>
<table>
	<thead>
	<tr>
		<th>id_user</th>
		<th>group</th>
		<th>first_name</th>
		<th>fam_name</th>
		<th>email</th>
		<th>pass</th>
		<th>about</th>
	</tr>
	</thead>
	<tbody>
<?php
	$result = mysql_query ('
	select id_user, title, first_name, fam_name, email, pass, about
	from users join groups
	on users.id_group = groups.id_group
	order by id_user
	');
	$col = mysql_num_fields($result);

	while ($row = mysql_fetch_array($result)) {
	echo "	<tr>\n";
	for ($i=0; $i<$col; $i++) {
		echo '		<td>' . $row[$i] . '</td>' . "\n";
		if ($i==$col-1)
			echo "\n";
		}
	echo "	</tr>\n";
	}

	?>
	</tbody>
</table>

<h2>Create user</h2>
<form action="?p=users" method="post">
	<div>
		<label for="id_group">Group</label>
		<select name="id_group" id="id_group">
			<option value="2">Admin</option>
			<option value="3">Teacher</option>
			<option value="4" selected="selected">Student</option>
		</select><br>
		<label for="first_name">First name</label>
		<input name="first_name" type="text" id="first_name"><br>
		<label for="fam_name">Family name</label>
		<input name="fam_name" type="text" id="fam_name"><br>
		<label for="email">Email</label>
		<input name="email" type="text" id="email">
		<label for="email">(this is your login)</label><br>
		<label for="pass">Password</label>
		<input name="pass" type="password" id="pass"><br>
		<label for="about">About you</label><br>
		<textarea name="about" rows="5" cols="60" id="about"></textarea><br>
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
	mysql_query("insert into users values (null, '$id_group', '$first_name', '$fam_name', '$email', '$pass', '$about')");
	header('Location: ?p=users');
}

} else
	header('Location: .');
?>
