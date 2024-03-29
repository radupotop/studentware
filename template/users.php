<?php
/**
 * @file
 * Display users.
 */

if ($_SESSION['login']) {
?>
<div id="users">

<h2>Groups</h2>
<?php

/**
 * Display groups add.
 * @return null
 */
function display_groups_add() {
?>
	<tr>
		<td>
		<input name="groups[add][title]" type="text" title="Title">
		</td>
		<td>
		<input name="groups[add][submit]" type="submit" value="Add group">
		</td>
	</tr>
<?php
	return;
}

/**
 * Display groups edit.
 * @return null
 */
function display_groups_edit() {
	global $groups;
	$result = mysql_query (
		'select title
		from groups
		where id_group = ' . $groups['edit']['req']
	);
	queryCount();
	$row = mysql_fetch_array($result);
?>
	<tr class="editing">
		<td>
			<input title="Title" name="groups[edit][title]" type="text"
				value="<?php echo $row['title'] ?>">
		</td>
		<td>
			<button name="groups[edit][submit]"
				value="<?php echo $groups['edit']['req'] ?>">
				Edit group</button>
		</td>
	</tr>
<?php
	return;
}

/**
 * Display groups.
 * @return null
 */
function display_groups() {
	global $groups;
?>
<form action="<?php echo current_page(true); ?>" method="post">
<table>
	<thead>
	<tr>
		<th>Group</th>
		<?php if ($_SESSION['id_group'] == 1) { ?>
		<th>Manage</th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
	$result = mysql_query (
		'select *
		from groups'
	);
	queryCount();
	while ($row = mysql_fetch_array($result)) {
		if($row['id_group'] == $groups['edit']['req']) {
			display_groups_edit();
		} else {
		echo
		'	<tr>' . "\n" .
		'		<td>' . $row['title'] . '</td>' . "\n";
		if($_SESSION['id_group'] == 1) {
			echo
		'		<td>' ."\n";
			echo
		'		<button name="groups[edit][req]" value="' . $row['id_group'] .
						'">Edit</button>' ."\n";
		// do not allow deletion of admin group
		if($row['id_group'] != 1) {
			echo
		'		<button name="groups[delete][req]" value="' . $row['id_group'] .
						'">Delete</button>' ."\n";
		}
			echo
		'		</td>' ."\n";
		}
		echo
		'	</tr>' . "\n";
		}
	}
	if($_SESSION['id_group'] == 1) {
		display_groups_add();
	}
?>
	</tbody>
</table>
</form>
<?php
	return;
}
display_groups();

/**
 * Display groups dropdown menu.
 * @param int $select - select group with this id
 * @return null
 */
function display_groups_dropdown($select) {
	$result = mysql_query(
		'select *
		from groups'
	);
	queryCount();
	while ($row = mysql_fetch_array($result)) {
		echo '			<option ';
		if($row['id_group'] == $select) {
			echo 'selected="selected" ';
		}
		echo 'value="'. $row['id_group'] .'">'. $row['title'] .'</option>'."\n";
	}
	return;
}

/**
 * Display users add.
 * @return null
 */
function display_users_add() {
?>
	<tr>
		<td>
		<select title="Group" name="id_group">
			<?php display_groups_dropdown(3); ?>
		</select>
		</td>
		<td>
		<input title="First name" name="first_name" type="text" id="first_name">
		</td>
		<td>
		<input title="Family name" name="fam_name" type="text" id="fam_name">
		</td>
		<td>
		<input title="Email" name="email" type="text" id="email">
		</td>
		<td>
		<input title="Password" name="pass" type="password" id="pass">
		</td>
		<td>
		<input title="About" name="about" type="text" id="about">
		</td>
		<td>
		<input name="add_user" type="submit" value="Add user">
		</td>
	</tr>
<?php
	return;
}

/**
 * Display users edit.
 * @return null
 */
function display_users_edit() {
	global $edit_user;
	$result = mysql_query(
		'select *
		from users
		where id_user=' . $edit_user
	);
	queryCount();
	$row = mysql_fetch_array($result);
?>
	<tr class="editing">
		<td>
		<select title="Group" name="x_id_group">
			<?php display_groups_dropdown($row['id_group']); ?>
		</select>
		</td>
		<td>
		<input title="First name" name="x_first_name" type="text"
			value="<?php echo $row['first_name']; ?>">
		</td>
		<td>
		<input title="Family name" name="x_fam_name" type="text"
			value="<?php echo $row['fam_name']; ?>">
		</td>
		<td>
		<input title="Email" name="x_email" type="text"
			value="<?php echo $row['email']; ?>">
		</td>
		<td>
		<input title="Password" name="x_pass" type="password">
		</td>
		<td>
		<input title="About" name="x_about" type="text"
			value="<?php echo $row['about']; ?>">
		</td>
		<td>
		<button name="submit_edit_user" value="<?php echo $edit_user; ?>">
			Edit user</button>
		</td>
	</tr>
<?php
	return;
}

/**
 * Display users.
 * @return null
 */
function display_users() {
	global $edit_user;
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
		<?php if ($_SESSION['id_group'] == 1) { ?>
		<th>Manage</th>
		<?php } ?>
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
	queryCount();

while ($row = mysql_fetch_array($result)) {
	if ($row['id_user'] == $edit_user) {
		display_users_edit();
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
		}
		echo
	'		</td>' . "\n";
	}
	echo
	'	</tr>' . "\n";
	}
}
	if ($_SESSION['id_group'] == 1) {
		display_users_add();
	}
?>
	</tbody>
</table>
</form>
<?php
	return;
}
display_users();
?>

</div>
<?php
} else {
	header('Location: .');
}
?>
