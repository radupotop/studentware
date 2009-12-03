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
		queryCount();
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
		queryCount();
		// also delete users from group
		mysql_query(
			'delete from users
			where id_group='.$delete
		);
		queryCount();
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
		queryCount();
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
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);

			$users = new UsersInput;
			$users->addUser(
				$filtered_data['id_group'],
				$filtered_data['first_name'],
				$filtered_data['fam_name'],
				$filtered_data['email'],
				$filtered_data['pass'],
				$filtered_data['about']
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

	if ($_SESSION['login'] && $delete_user) {
		$users = new UsersInput;
		$users->deleteUser($delete_user);
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

			// filter input
			$input_data = array(
				'x_id_group' => FILTER_VALIDATE_INT,
				'x_first_name' => FILTER_UNSAFE_RAW,
				'x_fam_name' => FILTER_UNSAFE_RAW,
				'x_email' => FILTER_VALIDATE_EMAIL,
				'x_pass' => FILTER_UNSAFE_RAW,
				'x_about' => FILTER_UNSAFE_RAW,
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);

			$filtered_data['x_about'] =
				$html_filter->process($filtered_data['x_about']);

			// edit user details
			$users = new UsersInput;
			$users->editUser(
				$submit_edit_user,
				$filtered_data['x_id_group'],
				$filtered_data['x_first_name'],
				$filtered_data['x_fam_name'],
				$filtered_data['x_email'],
				$filtered_data['x_pass'],
				$filtered_data['x_about']
			);

			// update session cookie with latest info
			if ($_SESSION['id_user'] == $submit_edit_user) {
				$session = new Session;
				$session->update(
					$filtered_data['x_id_group'],
					$filtered_data['x_first_name'],
					$filtered_data['x_fam_name'],
					$filtered_data['x_email']
				);
			}
		}
	return;
}
input_users_edit();
?>
