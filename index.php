<?php
include('header.php');
require('config.php');

mysql_connect($db_host, $db_user, $db_pass);
mysql_set_charset($db_char);
mysql_select_db($db_name);

include('users.php');

include('footer.php');
?>
