<?php
$is_index = true;
require('config.php');

mysql_connect($db_host, $db_user, $db_pass);
mysql_set_charset($db_char);
mysql_select_db($db_name);

include('header.php');
include('menu.php');
include('login.php');

$page = $_GET['p'];
$allowed = array('pages', 'forum', 'files', 'calendar', 'schedule', 'users');

if (in_array($page, $allowed))
	include ($page . '.php');
else
	include ('home.php');

include('footer.php');
?>
