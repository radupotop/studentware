<?php
/**
 * @file
 * Display page.
 */
	$p = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT); // current page
?>
<div id="pages">
<?php
/**
 * Display list of pages.
 * @return null
 */
function display_page_list() {
	global $site;
?>
<div id="page_list">
<h2>Pages</h2>
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
		select pages.id_page, pages.id_user, pages.date_modified,
			pages.title, users.first_name, users.fam_name
		from pages
		join users
		on pages.id_user=users.id_user
		where pages.id_page !='.$site['home'].'
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
	display_page_add();
?>
	</tbody>
</table>
</form>
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

		if ($_SESSION['login']) {
?>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" name="page[add][req]" value="Add page">
		</td>
	</tr>
<?php
		}
	return;
}
?>
</div>
</div>
