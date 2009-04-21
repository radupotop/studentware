<?php
require('config.php');

mysql_connect($db_host, $db_user, $db_pass);
mysql_set_charset($db_char);
mysql_select_db($db_name);

include('header.php');
include('menu.php');
include('login.php');

include('main.php');

include('footer.php');
?>
