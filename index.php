<?php
require('config.php');


mysql_connect($db_host, $db_user, $db_pass);

mysql_set_charset($db_char);
mysql_select_db($db_name);

$table = mysql_query('select * from studenti');
$col = mysql_num_fields($table);

while ($row = mysql_fetch_array($table)) {
	for ($i=0; $i<$col; $i++) {
		echo $row[$i] . "\t";
		if ($i==$col-1)
			echo "\n";
		}
}

?>
