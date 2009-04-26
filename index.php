<?php
include('functions/functions.php');

require('config.php');

mysql_connect($db_host, $db_user, $db_pass);
mysql_set_charset($db_char);
mysql_select_db($db_name);

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
