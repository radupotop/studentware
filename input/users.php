<?php
/**
 * @file
 * Input users.
 */
	$html_filter = new InputFilter($tags['forum']);
	$edit_user = filter_input(INPUT_POST, 'edit_user', FILTER_VALIDATE_INT);

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
				'first_name' => FILTER_SANITIZE_ENCODED,
				'fam_name' => FILTER_SANITIZE_ENCODED,
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
	if ($_SESSION['login'] && $delete_user && $delete_user != 1) {
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
				'x_first_name' => FILTER_SANITIZE_ENCODED,
				'x_fam_name' => FILTER_SANITIZE_ENCODED,
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
				'first_name = "' . $filtered_data['x_first_name'] . '", ' .
				'fam_name = "' . $filtered_data['x_fam_name'] . '", ' .
				'email = "' . $filtered_data['x_email'] . '", ';
			if($filtered_data['x_pass']) {
				$filtered_data['x_pass'] = sha1($filtered_data['x_pass']);
				$query = $query . 'pass = "' . $filtered_data['x_pass'] . '", ';
			}
			$query = $query .
				'about= "' . $filtered_data['x_about'] . '" ' .
				'where id_user = ' . $submit_edit_user;
			mysql_query($query);
			if ($_SESSION['id_user'] == $submit_edit_user) {

				$_SESSION['id_group'] = $filtered_data['x_id_group'];
				$_SESSION['first_name'] = $filtered_data['x_first_name'];
				$_SESSION['fam_name'] = $filtered_data['x_fam_name'];
				$_SESSION['email'] = $filtered_data['x_email'];
				$_SESSION['about'] = $filtered_data['x_about'];
			}
		}
	return;
}
input_users_edit();

?>
