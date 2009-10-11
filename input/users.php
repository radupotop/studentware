<?php
/**
 * @file
 * Input users.
 */
	$html_filter = new InputFilter($tags, $attr);
	$edit_user = filter_input(INPUT_POST, 'edit_user', FILTER_VALIDATE_INT);
	$groups['edit']['req'] = filter_var($_POST['groups']['edit']['req'],
		FILTER_VALIDATE_INT);

/**
 * Input groups add.
 * @return null
 */
function input_groups_add() {
	$title =  filter_var($_POST['groups']['add']['title'], FILTER_UNSAFE_RAW);
	$submit = $_POST['groups']['add']['submit'];
	if(
		$title
		&& $submit
		&& $_SESSION['id_group'] == 1
	) {
		mysql_query(
		'insert into groups
		values (null, "'. esc($title) .'")'
		);
	}
	return;
}
input_groups_add();

/**
 * Input groups delete.
 * @return null
 */
function input_groups_delete() {
	$delete = filter_var($_POST['groups']['delete']['req'],
		FILTER_VALIDATE_INT);
	if ($delete && $delete != 1 && $_SESSION['id_group'] == 1) {
		// delete group
		mysql_query(
			'delete from groups
			where id_group = ' . $delete
		);
		// also delete users from group
		mysql_query(
			'delete from users
			where id_group='.$delete
		);
	}
	return;
}
input_groups_delete();

/**
 * Input groups edit.
 * @return null
 */
function input_groups_edit() {
	$title =  filter_var($_POST['groups']['edit']['title'], FILTER_UNSAFE_RAW);
	$submit = filter_var($_POST['groups']['edit']['submit'],
		FILTER_VALIDATE_INT);
	if (
		$title
		&& $submit
		&& $_SESSION['id_group'] == 1
	) {
		mysql_query(
			'update groups
			set title = "'. esc($title) .'"
			where id_group = '. $submit
		);
	}
	return;
}
input_groups_edit();

/**
 * Input users add.
 * @return null
 */
function input_users_add() {
		global $html_filter;
		$add_user = $_POST['add_user'];

		if ($_SESSION['login'] && $add_user) {
			$input_data = array(
				'id_group' => FILTER_VALIDATE_INT,
				'first_name' => FILTER_UNSAFE_RAW,
				'fam_name' => FILTER_UNSAFE_RAW,
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_REQUIRE_ARRAY,
				'about' => FILTER_UNSAFE_RAW
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}
		if (
			$filtered_data['id_group'] &&
			$filtered_data['first_name'] &&
			$filtered_data['fam_name'] &&
			$filtered_data['email'] &&
			$filtered_data['pass']
		) {
			$valid = true;
		}
		if ($valid) {
			$filtered_data['pass'] = sha1($filtered_data['pass']);
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);
			mysql_query(
				'insert into users values (null, ' .
				$filtered_data['id_group'] . ', "' .
				esc($filtered_data['first_name']) . '", "' .
				esc($filtered_data['fam_name']) . '", "' .
				esc($filtered_data['email']) . '", "' .
				$filtered_data['pass'] . '", "' .
				esc($filtered_data['about']) . '")'
			);
		}
	return;
}
input_users_add();

/**
 * Input users delete.
 * @return null
 */
function input_users_delete() {
	$delete_user = filter_input(INPUT_POST, 'delete_user', FILTER_VALIDATE_INT);
	// do not allow deletion of id_user = 1
	if ($_SESSION['login'] && $delete_user && $delete_user != 1) {
		// delete user
		mysql_query(
			'delete from users
			where id_user = ' . $delete_user
		);
	}
	return;
}
input_users_delete();

/**
 * Input users edit.
 * @return null
 */
function input_users_edit() {
		global $html_filter;
		$submit_edit_user =
			filter_input(INPUT_POST, 'submit_edit_user', FILTER_VALIDATE_INT);
		if ($_SESSION['login'] && $submit_edit_user) {
			$input_data = array(
				'x_id_group' => FILTER_VALIDATE_INT,
				'x_first_name' => FILTER_UNSAFE_RAW,
				'x_fam_name' => FILTER_UNSAFE_RAW,
				'x_email' => FILTER_VALIDATE_EMAIL,
				'x_pass' => FILTER_UNSAFE_RAW,
				'x_about' => FILTER_UNSAFE_RAW,
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}

		if (
			$filtered_data['x_id_group'] &&
			$filtered_data['x_first_name'] &&
			$filtered_data['x_fam_name'] &&
			$filtered_data['x_email']
		) {
			$valid = true;
		}

		if ($valid) {
			$filtered_data['x_about'] =
				$html_filter->process($filtered_data['x_about']);
			$query =
				'update users set ' .
				'id_group = ' . $filtered_data['x_id_group'] . ', ' .
				'first_name = "' . esc($filtered_data['x_first_name']) . '", ' .
				'fam_name = "' . esc($filtered_data['x_fam_name']) . '", ' .
				'email = "' . esc($filtered_data['x_email']) . '", ';
			if($filtered_data['x_pass']) {
				$filtered_data['x_pass'] = sha1($filtered_data['x_pass']);
				$query = $query . 'pass = "' . $filtered_data['x_pass'] . '", ';
			}
			$query = $query .
				'about= "' . esc($filtered_data['x_about']) . '" ' .
				'where id_user = ' . $submit_edit_user;
			mysql_query($query);
			if ($_SESSION['id_user'] == $submit_edit_user) {

				$_SESSION['id_group'] = $filtered_data['x_id_group'];
				$_SESSION['first_name'] = $filtered_data['x_first_name'];
				$_SESSION['fam_name'] = $filtered_data['x_fam_name'];
				$_SESSION['email'] = $filtered_data['x_email'];
			}
		}
	return;
}
input_users_edit();

?>
