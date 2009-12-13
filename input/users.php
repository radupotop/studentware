<?php
/**
 * @file
 * Input users.
 */
	$html_filter = new InputFilter($tags, $attr);
	$edit_user = filter_input(INPUT_POST, 'edit_user', FILTER_VALIDATE_INT);
	$groups['edit']['req'] = filter_var($_POST['groups']['edit']['req'],
		FILTER_VALIDATE_INT);
	$DB = new DB;

/**
 * Input groups add.
 * @return null
 */
function input_groups_add() {
	global $DB;
	$title =  filter_var($_POST['groups']['add']['title'], FILTER_UNSAFE_RAW);
	$submit = $_POST['groups']['add']['submit'];
	if(
		$title
		&& $submit
		&& $_SESSION['id_group'] == 1
	) {
		$add = array(
			'title' => $title
		);
		$DB->add('groups', $add);
	}
	return;
}
input_groups_add();

/**
 * Input groups delete.
 * @return null
 */
function input_groups_delete() {
	global $DB;
	$delete = filter_var($_POST['groups']['delete']['req'],
		FILTER_VALIDATE_INT);
	if ($delete && $delete != 1 && $_SESSION['id_group'] == 1) {
		$DB->delete('groups', 'id_group', $delete);
		$DB->delete('users', 'id_group', $delete);
	}
	return;
}
input_groups_delete();

/**
 * Input groups edit.
 * @return null
 */
function input_groups_edit() {
	global $DB;
	$title =  filter_var($_POST['groups']['edit']['title'], FILTER_UNSAFE_RAW);
	$submit = filter_var($_POST['groups']['edit']['submit'],
		FILTER_VALIDATE_INT);
	if (
		$title
		&& $submit
		&& $_SESSION['id_group'] == 1
	) {
		$edit = array(
			'title' => $title
		);
		$DB->edit('groups', $edit, 'id_group', $submit);
	}
	return;
}
input_groups_edit();

/**
 * Input users add.
 * @return null
 */
function input_users_add() {
		global $html_filter, $DB;
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

			$add = array (
				'id_group' => $filtered_data['id_group'],
				'first_name' => $filtered_data['first_name'],
				'fam_name' => $filtered_data['fam_name'],
				'email' => $filtered_data['email'],
				'pass' => $filtered_data['pass'],
				'about' => $filtered_data['about']
			);
			$DB->add('users', $add);
		}
	return;
}
input_users_add();

/**
 * Input users delete.
 * @return null
 */
function input_users_delete() {
	global $DB;
	$delete_user = filter_input(INPUT_POST, 'delete_user', FILTER_VALIDATE_INT);

	if ($_SESSION['login'] && $delete_user) {
		$DB->delete('users', 'id_user', $delete_user);
	}
	return;
}
input_users_delete();

/**
 * Input users edit.
 * @return null
 */
function input_users_edit() {
		global $html_filter, $DB, $Session;
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
			$edit = array(
				'id_group' => $filtered_data['x_id_group'],
				'first_name' => $filtered_data['x_first_name'],
				'fam_name' => $filtered_data['x_fam_name'],
				'email' => $filtered_data['x_email'],
				'pass' => $filtered_data['x_pass'],
				'about' => $filtered_data['x_about']
			);
			$DB->edit('users', $edit, 'id_user', $submit_edit_user);

			// update session cookie with latest info
			if ($_SESSION['id_user'] == $submit_edit_user) {
				$Session->update(
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
