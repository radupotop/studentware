<?php
if ($is_index == false) die;
?>
<div id="forum">

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
	');

	while ($row = mysql_fetch_array($result)) {
	echo '	<tr>' . "\n";
	echo '		<td><a href="?p=' . $_GET['p'] . '&amp;t=' . $row['id_topic']
		. '">' . $row['title'] . '</a></td>' . "\n";
	echo '		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' .
		"\n";
	echo '		<td>' . $row['date_modified'] . '</td>' . "\n";
	echo '	</tr>' . "\n";
	}
?>
	</tbody>
</table>
</div>

<div id="posts">
<?php
$topic = $_GET['t'];

if ($topic) {
	$result = mysql_query('
		select *
		from topics
		where id_topic=' . $topic . '
	');
	$row = mysql_fetch_array($result);
	echo '<h2>' . $row['title'] . '</h2>' . "\n";

	$result = mysql_query('
		select posts.id_post, posts.id_user, posts.date_created, posts.body,
			users.first_name, users.fam_name
		from posts
		join users
		on posts.id_user=users.id_user
		where id_topic=' . $topic . '
		order by date_created
	');
	while ($row = mysql_fetch_array($result)) {
		echo
		'<p class="author">' . "\n" .
		'	<span class="user">' .
			$row['first_name'] . ' ' . $row['fam_name'] .
			'</span>' . "\n" .
		'	<span class="date">' . $row['date_created'] . '</span>' . "\n" .
		'</p>' . "\n" .
		'<p>' . $row['body'] . '</p>' . "\n\n";
	}
}
?>
</div>

</div>
