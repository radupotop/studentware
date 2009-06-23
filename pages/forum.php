<?php
/**
 * @file
 * Display forum.
 */
?>
<div id="forum">

<div id="topics">
	<h2>Topics</h2>
	<?php display_topic_list(); ?>
</div>

<div id="posts">
<?php
	if ($topic['add']['req']) {
		display_topic_add();
	} else
	if ($topic['id']) {
		display_post_list();
		display_post_add();
	}
?>
</div>

</div>


<?php
/**
 * Display list of topics
 * @return null
 */
function display_topic_list() {
?>
<form action="<?php echo current_page(true); ?>" method="post">
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
	'		<a href="?p=' . $_GET['p'] . '&amp;topic=' .
		$row['id_topic'] . '">' . trim_title($row['title'], 20) . '</a>' ."\n".
	'		</td>' . "\n" .
	'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' ."\n".
	'		<td>' . Date::from_sql($row['date_modified']) . '</td>' . "\n".
	'	</tr>' . "\n";
}
if ($_SESSION['login']) {
?>
	<tr>
		<td></td>
		<td></td>
		<td>
			<button name="topic[add][req]" value="true">Add topic</button>
		</td>
	</tr>
<?php
}
?>
	</tbody>
</table>
</form>
<?php
	return;
}

/**
 * Display list of posts
 * @return null
 */
function display_post_list() {
	global $topic;

	// View topic title.
	$result = mysql_query('
		select *
		from topics
		where id_topic=' . $topic['id'] . '
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
		where id_topic=' . $topic['id'] . '
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
		'<div class="content">' . $row['body'] . '</div>' .
		'</div>' .  "\n\n";
	}
	return;
}

/**
 * Display post add.
 * @return null
 */
function display_post_add() {
	global $topic;
	if ($_SESSION['login']) {
?>
	<form action="<?php echo current_page(true); ?>" method="post">
		<div id="reply">
			<h3>
				<label for="textarea">Reply</label>
			</h3>
			<textarea name="post[add][body]" rows="5" cols="57"
				id="textarea"></textarea><br>
			<button name="post[add][submit]" value="true">Post reply</button>
		</div>
	</form>
<?php
	}
	return;
}

/**
 * Display topic add.
 * @return null
 */
function display_topic_add() {
?>
	<form action="<?php echo current_page(true); ?>" method="post">
		<input name="topic[add][title]" type="text" class="page_title"><br><br>
		<textarea name="topic[add][body]" rows="10" cols="57"
			id="textarea"></textarea><br>
		<button name="topic[add][submit]" value="true">Submit</button>
	</form>
<?php
	return;
}
?>
