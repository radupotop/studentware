<?php
/**
 * @file
 * Input login.
 */
	global $login_fail;

/**
 * Input login.
 * @return null
 */
function input_login() {
		global $login_fail;
		$login = $_POST['login'];
		if ($login) {
			$input_data = array(
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_REQUIRE_ARRAY,
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);

			if (
			$filtered_data['email'] &&
			$filtered_data['pass']
			) {
				$valid = true;
			} else {
				$login_fail = true;
			}

			if ($valid) {
				$filtered_data['pass'] = sha1($filtered_data['pass']);
				$result = mysql_query(
					'select * from users
					where email = "' . $filtered_data['email'] .
					'" and pass = "' . $filtered_data['pass'] . '"'
				);
				$row = mysql_fetch_array($result);
				if ($row) {
					$_SESSION['login'] = true;
					$_SESSION['id_user'] = $row['id_user'];
					$_SESSION['id_group'] = $row['id_group'];
					$_SESSION['first_name'] = $row['first_name'];
					$_SESSION['fam_name'] = $row['fam_name'];
					$_SESSION['email'] = $row['email'];
				} else {
					$login_fail = true;
				}
			}
		}
	return;
}
input_login();

/**
 * Input logout.
 * @return null
 */
function input_logout() {
	$logout = $_POST['logout'];
	if ($logout) {
		unset($_SESSION);
		setcookie(session_name(), '', 0, '/');
		session_destroy();
	}
	return;
}
input_logout();

?>
