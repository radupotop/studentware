<?php
/**
 * @file
 * View, add, edit, delete users.
 */
if ($_SESSION['login']) {
	Action::users_add();
?>

<h2>Users</h2>
<form action="<?php echo current_page(true); ?>" method="post">
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
		<th>Manage</th>
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
	$edit_user = filter_input(INPUT_POST, 'edit_user', FILTER_VALIDATE_INT);
	$submit_edit_user = $_POST['submit_edit_user'];

	if ($submit_edit_user) {
		include('users_users_edit_submit.php');
	}

	if ($row['id_user'] == $edit_user) {
		include('users_users_edit.php');
	} else {
	echo
	'	<tr>' . "\n" .
	'		<td>' . $row['title'] . '</td>' . "\n" .
	'		<td>' . $row['first_name'] . '</td>' . "\n" .
	'		<td>' . $row['fam_name'] . '</td>' . "\n" .
	'		<td>' . $row['email'] . '</td>' . "\n" .
	'		<td>(Not shown)</td>' . "\n" .
	'		<td>' . trim_title($row['about'], 20) . '</td>' . "\n";
	/**
	 * Display admin controls.
	 */
	if ($_SESSION['id_group'] == 1) {
		echo
	'		<td>' . "\n" .
	'			<button name="edit_user" value="' . $row['id_user'] .
					'">Edit</button>' . "\n";
		/**
		 * Don't display delete button for id_user=1
		 */
		if($row['id_user'] != 1) {
			echo
	'			<button name="delete_user" value="' . $row['id_user'] .
					'">Delete</button>' . "\n";
			include('users_users_delete.php');
		}
		echo
	'		</td>' . "\n";
	}
	echo
	'	</tr>' . "\n";
	}
}
	if ($_SESSION['id_group'] == 1) {
		View::users_add();
	}
	?>

	</tbody>
</table>
</form>

<?php
} else {
	header('Location: .');
}
?>
