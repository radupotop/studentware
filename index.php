<?php
/**
 * @file
 * Load all the functions, configs, templates and pages needed.
 *
 * \mainpage
 * Studentware is a groupware for students.
 */
include('functions/functions.php');

require('config.php');

mysql_connect($db['host'], $db['user'], $db['pass']);
mysql_set_charset($db['char']);
mysql_select_db($db['name']);

include('template/header.php');
include('template/menu.php');
include('pages/login.php');

$page = $_GET['page'];
$allowed = array('pages', 'forum', 'files', 'calendar', 'schedule', 'users');

if (in_array($page, $allowed))
	include ('pages/' . $page . '.php');
else
	include ('pages/home.php');

include('template/footer.php');
?>
