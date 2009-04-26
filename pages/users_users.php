<?php
// view, add, edit, delete users
if ($_SESSION['login']) {
?>

<h2>Users</h2>
<form action="<?php echo current_page('escape'); ?>" method="post">
<table>
	<thead>
	<tr>
		<th>Group</th>
		<th>First name</th>
		<th>Family name</th>
		<th>Email</th>
		<th>Password</th>
		<th>About</th>
		<?php
			if ($_SESSION['id_group'] == 1) {
		?>
		<th class="manage">Manage</th>
		<?php
			}
		?>
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
	'		<td>' . trim_title($row['about'], 20) . '</td>' . "\n" .
	'		<td></td>' . "\n" .
	'	</tr>' . "\n";
	}
	if ($_SESSION['id_group'] == 1)
		include('users_users_add.php');
	?>

	</tbody>
</table>
</form>

<?php
} else {
	header('Location: ' . current_page());
}
?>
