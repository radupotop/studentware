<?php
/**
 * @file
 * Display users.
 */

$groupsArray = $Model->view('groups');
$usersArray = $Model->view('users');

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
	global $groups, $groupsArray;
	$id_group = $groups['edit']['req'];
?>
	<tr class="editing">
		<td>
			<input title="Title" name="groups[edit][title]" type="text"
				value="<?php echo $groupsArray[$id_group]['title'] ?>">
		</td>
		<td>
			<button name="groups[edit][submit]"
				value="<?php echo $id_group ?>">
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
	global $groups, $groupsArray;
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
	foreach($groupsArray as $group) {
		if($group['id_group'] == $groups['edit']['req']) {
			display_groups_edit();
		} else {
			// admin controls
			if($_SESSION['id_group'] == 1) {
				$controls = '<td>';
				$controls .= sprintf('<button name="groups[edit][req]" value="%s">Edit</button> ', $group['id_group']);
				if($group['id_group'] != 1)
					$controls .= sprintf('<button name="groups[delete][req]" value="%s">Delete</button> ', $group['id_group']);
				$controls .= '</td>';
			}
			echo sprintf(
			'<tr>
				<td>%s</td>
				%s
			</tr>',
			$group['title'],
			$controls
			);
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
 */
function display_groups_dropdown($select=null) {
	global $groupsArray;

	if(!$select) {
		$lastGroup = end($groupsArray);
		$select = $lastGroup['id_group'];
	}
	foreach($groupsArray as $group) {
		if($group['id_group'] == $select)
			$selectCode = ' selected="selected"';
		else
			$selectCode = null;
		echo sprintf('<option value="%s"%s>%s</option>',
		$group['id_group'], $selectCode, $group['title']);
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
			<?php display_groups_dropdown(); ?>
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
	global $edit_user, $usersArray;
?>
	<tr class="editing">
		<td>
		<select title="Group" name="x_id_group">
			<?php display_groups_dropdown($usersArray[$edit_user]['id_group']); ?>
		</select>
		</td>
		<td>
		<input title="First name" name="x_first_name" type="text"
			value="<?php echo $usersArray[$edit_user]['first_name'] ?>">
		</td>
		<td>
		<input title="Family name" name="x_fam_name" type="text"
			value="<?php echo $usersArray[$edit_user]['fam_name'] ?>">
		</td>
		<td>
		<input title="Email" name="x_email" type="text"
			value="<?php echo $usersArray[$edit_user]['email'] ?>">
		</td>
		<td>
		<input title="Password" name="x_pass" type="password">
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
	global $edit_user, $groupsArray, $usersArray;
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
		<?php if ($_SESSION['id_group'] == 1) { ?>
		<th>Manage</th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
	foreach($usersArray as $user) {
	if ($user['id_user'] == $edit_user) {
		display_users_edit();
	} else {
		// admin controls
		if($_SESSION['id_group'] == 1) {
			$controls = '<td>';
			$controls .= sprintf('<button name="edit_user" value="%s">Edit</button> ', $user['id_user']);
			if($user['id_user'] != 1)
				$controls .= sprintf('<button name="delete_user" value="%s">Delete</button> ', $user['id_user']);
			$controls .= '</td>';
		}
		echo sprintf(
		'<tr>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>(Not shown)</td>
			%s
		</tr>',
		$groupsArray[$user['id_group']]['title'],
		$user['first_name'],
		$user['fam_name'],
		$user['email'],
		$controls
		);
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
