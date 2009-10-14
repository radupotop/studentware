<?php
/**
 * @file
 * Load all the functions, configs, templates and pages needed.
 *
 * \mainpage
 * Studentware is a groupware for students.
 */
require('config.php');
include('functions/functions.php');

$p = $_GET['p'];
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
include('template/header.php');

if (in_array($p, $allowed)) {
	include ('pages/' . $p . '.php');
} else {
	include ('pages/home.php');
}

include('template/sidebar.php');
include('template/footer.php');
?>
