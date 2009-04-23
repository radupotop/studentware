<?php
if ($is_index == false) die;
?>
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
		'	<span class="date">' . date::from_sql($row['date_created']) .
		'</span>' . "\n" . '</p>' . "\n" .
		'<p class="content">' . $row['body'] . '</p>' . "\n\n";
	}
}
?>
</div>
