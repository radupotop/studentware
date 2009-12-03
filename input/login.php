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

		$session = new Session;
		$status = $session->login(
			$filtered_data['email'], $filtered_data['pass']);

		if (!$status)
			$login_fail = true;
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
		$session = new Session;
		$session->logout();
	}
	return;
}
input_logout();

?>
