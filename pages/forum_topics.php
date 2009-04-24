<div id="topics">
<h2>Topics</h2>
<table>
	<thead>
	<tr>
		<th>Title</th>
		<th>Started by</th>
		<th>Last post</th>
	</tr>
	</thead>
	<tbody>
<?php
$result = mysql_query('
		select topics.id_topic, topics.id_user, topics.date_modified,
			topics.title, users.first_name, users.fam_name
		from topics
		join users
		on topics.id_user=users.id_user
		order by date_modified desc
	');

	while ($row = mysql_fetch_array($result)) {
	echo '	<tr>' . "\n";
	echo '		<td><a href="?page=forum&amp;topic=' . $row['id_topic']
		. '">' . $row['title'] . '</a></td>' . "\n";
	echo '		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' .
		"\n";
	echo '		<td>' . date::from_sql($row['date_modified']) . '</td>' . "\n";
	echo '	</tr>' . "\n";
	}
?>
	</tbody>
</table>
</div>
