<div id="posts">

<?php
$topic = $_GET['topic'];

if ($topic) {
	// Topic title
	$result = mysql_query('
		select *
		from topics
		where id_topic=' . $topic . '
	');
	$row = mysql_fetch_array($result);
	echo '<h2>' . $row['title'] . '</h2>' . "\n";

	// List posts
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
		'<div id="post' . $row['id_post'] . '">' . "\n" .
		'<p class="author">' . "\n" .
		'	<a class="id" href="#post' . $row['id_post'] . '">#</a>' . "\n" .
		'	<span class="user">' .
			$row['first_name'] . ' ' . $row['fam_name'] .
			'</span>' . "\n" .
		'	<span class="date">' . Date::from_sql($row['date_created']) .
		'</span>' . "\n" .
		'</p>' . "\n" .
		'<p class="content">' . $row['body'] . '</p>' .
		'</div>' .  "\n\n";
	}

	// Add post
	if ($_SESSION['login']) {
?>

	<form action="<?php echo current_page('escape'); ?>" method="post">
	<div id="reply">
		<h3><label for="post">Reply</label></h3>
		<textarea name="post" rows="5" cols="60" id="post"></textarea><br>
		<input name="reply" type="submit" value="Post reply">
		<p class="allowed_tags">Allowed HTML tags:
			<?php
				echo implode(', ', $allowed_tags);
			?>
		</p>
	</div>
	</form>

<?php
$post = $_POST['post'];
$reply = $_POST['reply'];

$post = $html_filter->process($post);

if($reply && $post) {
	mysql_query('
		insert into posts
		values (null, ' . $topic . ', ' . $_SESSION['id_user'] . ', "' .
			Date::to_sql('now') . '", "' . $post . '")
	');
	mysql_query('
		update topics
		set date_modified="' . Date::to_sql('now') . '"
		where id_topic=' . $topic . '
	');
	header('Location: ' . current_page());
}
	}

}
?>
</div>
