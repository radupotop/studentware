<?php
/**
 * @file
 * Input login.
 */

$Session = new Session;

/**
 * Input login.
 * @return null
 */
function input_login() {
	global $login_fail, $Session;
	$login = $_POST['login'];
	if ($login) {
		$input_data = array(
			'email' => FILTER_VALIDATE_EMAIL,
			'pass' => FILTER_REQUIRE_ARRAY,
		);
		$filtered_data = filter_input_array(INPUT_POST, $input_data);

		$status = $Session->login(
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
	global $Session;
	$logout = $_POST['logout'];
	if ($logout)
		$Session->logout();
	return;
}
input_logout();

?>
