<?php
// create, edit, delete users
if ($_SESSION['login']) {
?>

<h2>Users</h2>
<table>
	<thead>
	<tr>
		<th>Group</th>
		<th>First name</th>
		<th>Family name</th>
		<th>Email</th>
		<th>Password</th>
		<th>About</th>
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
	echo
	'	<tr>' . "\n" .
	'		<td>' . $row['title'] . '</td>' . "\n" .
	'		<td>' . $row['first_name'] . '</td>' . "\n" .
	'		<td>' . $row['fam_name'] . '</td>' . "\n" .
	'		<td>' . $row['email'] . '</td>' . "\n" .
	'		<td>(Not shown)</td>' . "\n" .
	'		<td>' . $row['about'] . '</td>' . "\n" .
	'	</tr>' . "\n";
	}
	?>

	</tbody>
</table>

<?php
if ($_SESSION['id_group'] == 1)
	include('users_users_add.php');

} else
	header('Location: .');
?>
