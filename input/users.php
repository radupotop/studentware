<?php
/**
 * @file
 * Input users.
 */
	$html_filter = new InputFilter($tags['forum']);

/**
 * Input users add.
 * @return null
 */
function input_users_add() {
		$add_user = $_POST['add_user'];

		if ($add_user) {
			$input_data = array(
				'id_group' => FILTER_VALIDATE_INT,
				'first_name' => FILTER_SANITIZE_ENCODED,
				'fam_name' => FILTER_SANITIZE_ENCODED,
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_REQUIRE_ARRAY,
				'about' => FILTER_UNSAFE_RAW,
				'add_user' => FILTER_REQUIRE_ARRAY
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}
		if (
			$filtered_data['id_group'] &&
			$filtered_data['first_name'] &&
			$filtered_data['fam_name'] &&
			$filtered_data['email'] &&
			$filtered_data['pass'] &&
			$filtered_data['add_user']
		) {
			$valid = true;
		}
		if ($valid) {
			$filtered_data['pass'] = sha1($filtered_data['pass']);
			global $html_filter;
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);
			mysql_query(
				'insert into users values (null, ' .
				$filtered_data['id_group'] . ', "' .
				$filtered_data['first_name'] . '", "' .
				$filtered_data['fam_name'] . '", "' .
				$filtered_data['email'] . '", "' .
				$filtered_data['pass'] . '", "' .
				$filtered_data['about'] . '")'
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
	if ($delete_user && $delete_user != 1) {
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
		if ($submit_edit_user) {
			$input_data = array(
				'id_group' => FILTER_VALIDATE_INT,
				'first_name' => FILTER_SANITIZE_ENCODED,
				'fam_name' => FILTER_SANITIZE_ENCODED,
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_UNSAFE_RAW,
				'about' => FILTER_UNSAFE_RAW,
				'submit_edit_user' => FILTER_REQUIRE_ARRAY
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}

		if (
			$filtered_data['id_group'] &&
			$filtered_data['first_name'] &&
			$filtered_data['fam_name'] &&
			$filtered_data['email'] &&
			$filtered_data['submit_edit_user']
		) {
			$valid = true;
		}

		if ($valid) {
			$filtered_data['pass'] = sha1($filtered_data['pass']);
			global $html_filter;
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);
			mysql_query(
				'update users set ' .
				'id_group = ' . $filtered_data['id_group'] . ', ' .
				'first_name = "' . $filtered_data['first_name'] . '", ' .
				'fam_name = "' . $filtered_data['fam_name'] . '", ' .
				'email = "' . $filtered_data['email'] . '", ' .
				'pass = "' . $filtered_data['pass'] . '", ' .
				'about= "' . $filtered_data['about'] . '" ' .
				'where id_user = ' . $row['id_user']
			);
		}
	return;
}
input_users_edit();

?>
