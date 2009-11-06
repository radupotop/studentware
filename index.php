<?php
/**
 * @file
 * Load all the functions, configs, templates and pages needed.
 *
 * \mainpage
 * Studentware is a groupware for students.
 */
require_once('config.php');
require_once('functions/functions.php');

$p = $_GET['p'];

if (($p || $argv[1]) == 'cron') {
	include('functions/cronjobs.php');
	die;
}

$allowed = array(
	'pages', 'forum', 'files', 'calendar', 'schedule', 'users', 'register'
);

/**
 * Input
 */
include('input/login.php');

if (in_array($p, $allowed)) {
	include ('input/' . $p . '.php');
} else {
	include ('input/home.php');
}

/**
 * Pages
 */
include('template/_header.php');

if (in_array($p, $allowed)) {
	include ('template/' . $p . '.php');
} else {
	include ('template/home.php');
}

include('template/login.php');
include('template/_footer.php');

?>
