<?php
// create, edit, delete groups
?>

<h2>Groups</h2>
<table>
	<thead>
	<tr>
		<th>Group</th>
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
	echo
	'	<tr>' . "\n" .
	'		<td>' . $row['title'] . '</td>' . "\n" .
	'	</tr>' . "\n";
	}

	?>
	</tbody>
</table>

