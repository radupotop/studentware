<?php
// create, edit, delete groups
?>

<h2>Groups</h2>
<table>
	<thead>
	<tr>
		<th>id_group</th>
		<th>title</th>
	</tr>
	</thead>
	<tbody>
<?php
	$result = mysql_query ('
	select *
	from groups
	');
	$col = mysql_num_fields($result);

	while ($row = mysql_fetch_array($result)) {
	echo "	<tr>\n";
	for ($i=0; $i<$col; $i++) {
		echo '		<td>' . $row[$i] . '</td>' . "\n";
		if ($i==$col-1)
			echo "\n";
		}
	echo "	</tr>\n";
	}

	?>
	</tbody>
</table>

