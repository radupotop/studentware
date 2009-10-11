<?php
/**
 * @file
 * Display forum.
 */
?>
<div id="forum">

<div id="topic_list">
	<h2>Topics</h2>
	<?php display_topic_list(); ?>
</div>

<div id="post_list">
<?php
	if ($topic['add']['req']) {
		display_topic_add();
	} else
	if ($topic['id']) {
		display_post_list();
		if ($post['edit']['req'] == false) {
			display_post_add();
		}
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
	global $topic;
?>
<form action="<?php echo current_page(true); ?>" method="post">
<table>
	<thead>
	<tr>
		<th>Title</th>
		<th>Started by</th>
		<th>Last post</th>
	<?php if ($_SESSION['login']) { ?>
		<th>Manage</th>
	<?php } ?>
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
	if($topic['edit']['req'] == $row['id_topic']) {
		display_topic_edit();
	} else {
?>
<tr>
	<td>
		<a href="<?php echo '?p='.$_GET['p'].'&amp;topic='.$row['id_topic'] ?>">
			<?php echo trim_title($row['title'], 20) ?>
		</a>
	</td>
	<td><?php echo $row['first_name'].' '.$row['fam_name'] ?></td>
	<td><?php echo Date::from_sql($row['date_modified']) ?></td>
	<?php
	if (
		// if users owns element or if user is admin display edit & delete
		$_SESSION['id_user'] == $row['id_user'] ||
		$_SESSION['id_group'] == 1
	) {
	?>
	<td>
		<button name="topic[edit][req]"
			value="<?php echo $row['id_topic'] ?>">Edit</button>
		<button name="topic[delete][req]"
			value="<?php echo $row['id_topic'] ?>">Delete</button>
	</td>
	<?php
	} else if ($_SESSION['login']) {
		echo
		'<td></td>';
	}

	?>
</tr>
<?php
	}
}
if ($_SESSION['login']) {
?>
	<tr>
		<td></td>
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
	global $topic, $post;

	// display topic title.
	$result = mysql_query('
		select *
		from topics
		where id_topic=' . $topic['id'] . '
	');
	$row = mysql_fetch_array($result);
	echo '<h2>' . $row['title'] . '</h2>' ."\n";

	// display posts from topic.
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
		// display edit?
		if ($post['edit']['req'] == $row['id_post']) {
			display_post_edit();
		} else {
		// display individual post
?>
	<div id="post<?php echo $row['id_post'] ?>" class="post">
		<p class="author">
			<a class="id" href="#post<?php echo $row['id_post'] ?>">#</a>
			<span class="user">
				<?php echo $row['first_name'] . ' ' . $row['fam_name'] ?>
			</span>
			<span class="date">
				<?php echo Date::from_sql($row['date_created']) ?>
			</span>
		</p>
		<div class="content">
			<?php echo $row['body'] ?>
		</div>
		<?php
			// display edit & delete buttons for post
			if($_SESSION['id_group'] == 1
			|| $_SESSION['id_user'] == $row['id_user']) {
		?>
		<form action="<?php echo current_page(true); ?>" method="post">
		<p>
			<button name="post[edit][req]"
				value="<?php echo $row['id_post'] ?>">Edit</button>
			<button name="post[delete][req]"
				value="<?php echo $row['id_post'] ?>">Delete</button>
		</p>
		</form>
		<?php } ?>
	</div>
<?php
		}
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
			<textarea name="post[add][body]" rows="18" cols="100"
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
		<textarea name="topic[add][body]" rows="18" cols="100"
			id="textarea"></textarea><br>
		<button name="topic[add][submit]" value="true">Submit</button>
	</form>
<?php
	return;
}

/**
 * Display topic edit
 * @return null
 */
function display_topic_edit() {
	global $topic;

	if ($_SESSION['login']) {
		$result = mysql_query (
			'select *
			from topics
			where id_topic='.$topic['edit']['req']
		);
		$row = mysql_fetch_array($result);
?>
<tr class="editing">
	<td colspan="3">
		<input type="text" name="topic[edit][title]" size="70"
			value="<?php echo $row['title'] ?>">
	</td>
	<td>
		<button name="topic[edit][submit]"
			value="<?php echo $row['id_topic'] ?>">Edit topic</button>
	</td>
</tr>
<?php
	}
	return;
}

/**
 * Display post edit.
 * @return null
 */
function display_post_edit() {
	global $post;

	if ($_SESSION['login']) {
		$result = mysql_query (
			'select *
			from posts
			where id_post='.$post['edit']['req']
		);
		$row = mysql_fetch_array($result);
?>
	<form action="<?php echo current_page(true); ?>" method="post">
		<div>
			<textarea name="post[edit][body]" rows="8" cols="100"
				id="textarea"><?php echo $row['body'] ?></textarea><br>
			<button name="post[edit][submit]"
				value="<?php echo $row['id_post'] ?>">Submit</button>
			<button value="true">Cancel</button>
		</div>
	</form>
<?php
	}
	return;
}
?>
