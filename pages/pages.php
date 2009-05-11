<?php
/**
 * @file
 * Display page.
 */
	$p = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);
	global $tags;
?>
<div id="pages">
<?php
/**
 * Display page list.
 * @return null
 */
function display_page_list() {
?>
<div id="page_list">
<h2>Pages</h2>
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
		select pages.id_page, pages.id_user, pages.date_modified,
			pages.title, pages.is_home, users.first_name, users.fam_name
		from pages
		join users
		on pages.id_user=users.id_user
		where pages.is_home = 0
		order by date_modified desc
	');

while ($row = mysql_fetch_array($result)) {
	echo
	'	<tr>' . "\n" .
	'		<td>' . "\n" .
	'		<a href="?page=' . $_GET['page'] . '&amp;p=' .
		$row['id_page'] . '">' . trim_title($row['title'], 20) . '</a>' ."\n".
	'		</td>' . "\n" .
	'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' ."\n".
	'		<td>' . Date::from_sql($row['date_modified']) . '</td>' . "\n" .
	'	</tr>' . "\n";
}
?>
	</tbody>
</table>
</div>
<?php
	return;
}
display_page_list();

/**
 * Display page.
 * @return null
 */
function display_page() {
?>
<div id="page">
<?php
	global $p;
	if ($p) {
		$result = mysql_query(
			'select pages.id_page, pages.id_user, pages.date_modified,
				pages.title, pages.body, users.id_user, users.first_name,
				users.fam_name
			from pages
			join users
			on pages.id_user = users.id_user
			where id_page='.$p
		);
		$row = mysql_fetch_array($result);
		// View page title.
		echo '<h2>' . $row['title'] . '</h2>' ."\n";

		// View page.
		echo
		'<p class="author">' . "\n" .
			'	<span class="user">' .
				$row['first_name'] . ' ' . $row['fam_name'] .
				'</span>' . "\n" .
			'	<span class="date">' . Date::from_sql($row['date_modified']) .
			'</span>' . "\n" .
		'</p>' . "\n";
		echo
		'<div id="body">'."\n".
		$row['body'];
		'</div>'."\n";
	}
?>
</div>
<?php
	return;
}
display_page();

/**
 * Display page add.
 * @return null
 */
function display_page_add() {
		global $p;
		global $tags;

		if ($_SESSION['login'] && $p) {
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
//display_page_add();
?>
</div>
</div>
