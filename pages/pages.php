<?php
/**
 * @file
 * Display page.
 */
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
	'		<a href="?p=' . $_GET['p'] . '&amp;pag=' .
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
	global $pag;
?>
<div id="page">
<?php
	if ($page['edit']['req']) {
		display_page_edit();
	} else if ($pag) {
		$result = mysql_query(
			'select pages.id_page, pages.id_user, pages.date_modified,
				pages.title, pages.body, users.id_user, users.first_name,
				users.fam_name
			from pages
			join users
			on pages.id_user = users.id_user
			where id_page='.$pag
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
		?>
		<form action="<?php echo current_page(true); ?>" method="post">
		<?php
		if ($_SESSION['id_group'] == 1) {
			echo '<p>
				<button name="page[edit][req]"
					value="'.$row['id_page'].'">Edit</button>'."\n".
				'<button name="page[delete][req]"
					value="'.$row['id_page'].'">Delete</button></p>'."\n";
		}
		?>
		</form>
		<?php
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
		global $pag;

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

/**
 * Display page edit.
 * @return null
 */
function display_page_edit() {
	$result = mysql_query(
		'select *
		from pages
		where id_page='.$page['edit']['req']
	);
	$row = mysql_fetch_array($result);
?>
	<input name="page[edit][title]" type="text"
		value="<?php echo $row['title'] ?>"><br><br>
	<textarea name="page[edit][body]" rows="18" cols="80">
		<?php echo $row['body'] ?></textarea><br><br>
	<button name="page[edit][submit]"
		value="<?php echo $row['id_page'] ?>">Submit</button>
<?php
	return;
}
?>
</div>
</div>
