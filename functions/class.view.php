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
	static function topics() {
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
	static function posts() {

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
	static function posts_add() {

		global $topic;
		global $tags;

		if ($_SESSION['login'] && $topic) {
?>
	<form action="<?php echo current_page(true); ?>" method="post">
		<div id="reply">
			<h3><label for="post">Reply</label></h3>
			<textarea name="post" rows="5" cols="60" id="post"></textarea><br>
			<input name="reply" type="submit" value="Post reply">
			<p class="allowed_tags">Allowed HTML tags:
				<?php echo implode(', ', $tags['forum']); ?>
			</p>
		</div>
	</form>
<?php
		}
	return;
	}

	/**
	 * View logout.
	 * @return null
	 */
	static function logout() {
		if ($_SESSION['login']) {
?>
		<form action="<?php echo current_page(true); ?>" method="post">
			<div>
				Hello <strong><?php echo $_SESSION['first_name'] . ' '
				. $_SESSION['fam_name']; ?></strong>
				<input name="logout" type="submit" value="Logout">
			</div>
		</form>
<?php
		}
	return;
	}

	/**
	 * View login.
	 * @return null
	 */
	static function login() {
		if ($_SESSION['login']==false) {
?>
<form action="<?php echo current_page(true); ?>" method="post">
	<div>
		<label for="email">Email</label>
		<input name="email" type="text" id="email">
		<label for="pass">Password</label>
		<input name="pass" type="password" id="pass">
		<input name="login" type="submit" value="Login">
	</div>
</form>
<?php
		}
	return;
	}

	/**
	 * View login error.
	 * @return null
	 */
	static function login_error() {
?>
		<span class="error">Login incorrect</span>
<?php
	return;
	}

	/**
	 * View users add.
	 * @return null
	 */
	static function users_add() {
?>
	<tr>
		<td>
		<select title="Group" name="id_group" id="id_group">
			<option value="1">Admin</option>
			<option value="2">Teacher</option>
			<option value="3" selected="selected">Student</option>
		</select>
		</td>
		<td>
		<input title="First name" name="first_name" type="text" id="first_name">
		</td>
		<td>
		<input title="Family name" name="fam_name" type="text" id="fam_name">
		</td>
		<td>
		<input title="Email" name="email" type="text" id="email">
		</td>
		<td>
		<input title="Password" name="pass" type="password" id="pass">
		</td>
		<td>
		<input title="About" name="about" type="text" id="about">
		</td>
		<td>
		<input name="add_user" type="submit" value="Add user">
		</td>
	</tr>
<?php
	return;
	}


} // end class.
?>
