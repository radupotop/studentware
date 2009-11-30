<?php
/**
 * @file
 * Input register
 */

function input_register() {
	global $site;

	$register['first_name'] =
		filter_var($_POST['register']['first_name'], FILTER_UNSAFE_RAW);
	$register['fam_name'] =
		filter_var($_POST['register']['fam_name'], FILTER_UNSAFE_RAW);
	$register['email'] =
		filter_var($_POST['register']['email'], FILTER_VALIDATE_EMAIL);
	$register['pass'] =
		filter_var($_POST['register']['pass'], FILTER_UNSAFE_RAW);
	$register['pass_verif'] =
		filter_var($_POST['register']['pass_verif'], FILTER_UNSAFE_RAW);
	$register['code'] =
		filter_var($_POST['register']['code'], FILTER_UNSAFE_RAW);
	$register['submit'] =
		filter_var($_POST['register']['submit'], FILTER_UNSAFE_RAW);

	if (
		$register['first_name'] &&
		$register['fam_name'] &&
		$register['email'] &&
		$register['pass'] &&
		$register['pass_verif'] &&
		$register['code'] &&
		$register['submit'] &&

		$register['pass'] == $register['pass_verif'] &&
		sha1($register['code']) == $site['reg']['code']
	) {
		$users = new UsersInput;
		$users->addUser(
			3,
			$register['first_name'],
			$register['fam_name'],
			$register['email'],
			$register['pass']
		);
		header('Location: .');
	}

	return;
}
if ($_SESSION['login']==false && $site['reg']['enabled']) {
	input_register();
}
?>
