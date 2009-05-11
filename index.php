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

$page = $_GET['page'];
$allowed = array('pages', 'forum', 'files', 'calendar', 'schedule', 'users');

/**
 * Input
 */
include('input/login.php');

if (in_array($page, $allowed)) {
	include ('input/' . $page . '.php');
} else {
	include ('input/home.php');
}

/**
 * Pages
 */
include('template/header.php');

if (in_array($page, $allowed)) {
	include ('pages/' . $page . '.php');
} else {
	include ('pages/home.php');
}

include('template/sidebar.php');
include('debug/debug.php');
include('template/footer.php');
?>
