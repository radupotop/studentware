<?php
/**
 * View users, topics, etc.
 * @class View
 */
class View {

	/**
	 * View topics.
	 * @return null
	 */
	function topics() {
?>
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
	echo
	'	<tr>' . "\n" .
	'		<td>' . "\n" .
	'		<a href="?page=' . $_GET['page'] . '&amp;topic=' .
		$row['id_topic'] . '">' . trim_title($row['title'], 20) . '</a>' ."\n".
	'		</td>' . "\n" .
	'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' ."\n".
	'		<td>' . Date::from_sql($row['date_modified']) . '</td>' . "\n" .
	'	</tr>' . "\n";
}
?>
	</tbody>
</table>
<?php
	return;
	}

	/**
	 * View posts.
	 * @return null
	 */
	function posts() {

		global $topic;
		// View topic title.
	if ($topic) {
		$result = mysql_query('
			select *
			from topics
			where id_topic=' . $topic . '
		');
		$row = mysql_fetch_array($result);
		echo '<h2>' . $row['title'] . '</h2>' ."\n";


		// View posts from topic.
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
			'	<a class="id" href="#post' . $row['id_post'] . '">#</a>' ."\n".
			'	<span class="user">' .
				$row['first_name'] . ' ' . $row['fam_name'] .
				'</span>' . "\n" .
			'	<span class="date">' . Date::from_sql($row['date_created']) .
			'</span>' . "\n" .
			'</p>' . "\n" .
			'<p class="content">' . $row['body'] . '</p>' .
			'</div>' .  "\n\n";
		}
	}
	return;
	}

	/**
	 * View add posts.
	 * @return null
	 */
	function posts_add() {

		global $topic;
		global $allowed_tags;

		if ($_SESSION['login'] && $topic) {
?>
	<form action="<?php echo current_page('escape'); ?>" method="post">
		<div id="reply">
			<h3><label for="post">Reply</label></h3>
			<textarea name="post" rows="5" cols="60" id="post"></textarea><br>
			<input name="reply" type="submit" value="Post reply">
			<p class="allowed_tags">Allowed HTML tags:
				<?php echo implode(', ', $allowed_tags); ?>
			</p>
		</div>
	</form>
<?php
		}
	return;
	}



} // end class.
?>
