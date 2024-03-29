<?php
/**
 * @file
 * Display page.
 */
?>
<div id="pages">
<h2 class="cat_title">Pages</h2>
<p class="cat_desc">Wiki-like pages. May contain articles, how-tos, instructions, course notes, etc.</p>

<?php
/**
 * Display list of pages.
 * @return null
 */
function display_page_list() {
	global $site;
?>
<div id="page_list">
<form action="<?php echo current_page(true); ?>" method="post">
<table>
	<thead>
	<tr>
		<th>Title</th>
		<th>Started by</th>
		<th>Last post</th>
		<?php if($_SESSION['login']) { ?>
			<th>Manage</th>
		<?php } ?>
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
	queryCount();

while ($row = mysql_fetch_array($result)) {
	echo
	'	<tr>' . "\n" .
	'		<td>' . "\n" .
	'		<a href="?p=' . $_GET['p'] . '&amp;id=' .
		$row['id_page'] . '">' . trim_title($row['title'], 30) . '</a>' ."\n".
	'		</td>' . "\n" .
	'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' ."\n".
	'		<td>' . Date::from_sql($row['date_modified']) . '</td>' . "\n";
	if (
		// if users owns element or if user is admin display edit & delete
		$_SESSION['id_user'] == $row['id_user'] ||
		$_SESSION['id_group'] == 1
	) {
		echo '<td>
			<button name="page[edit][req]"
				value="'.$row['id_page'].'">Edit</button>'."\n".
			'<button name="page[delete][req]"
				value="'.$row['id_page'].'">Delete</button>
			</td>'."\n";
	} else if ($_SESSION['login']) {
		echo
		'<td></td>';
	}
	echo '	</tr>' . "\n";
}
	// add page request
	if ($_SESSION['login']) {
?>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td>
		<button name="page[add][req]" value="Add page">Add page</button>
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
</form>
<br>
</div>
<?php
	return;
}
display_page_list();


?>
<div id="page">
<?php
// display page, page add, page edit.
if ($page['add']['req']) {
	display_page_add();
} else
if ($page['edit']['req']) {
	display_page_edit();
} else
if ($page['id']) {
	display_page();
}
?>
</div>
<?php


/**
 * Display page.
 * @return null
 */
function display_page() {
	global $page;
		$result = mysql_query(
			'select pages.id_page, pages.id_user, pages.date_modified,
				pages.title, pages.body, users.id_user, users.first_name,
				users.fam_name
			from pages
			join users
			on pages.id_user = users.id_user
			where id_page='.$page['id']
		);
		queryCount();
		$row = mysql_fetch_array($result);
		// redirect to page list if page is deleted, or page 1 requested
		if ($row == false || $page['id'] == 1) {
			header('Location: ?p=' . $_GET['p']);
		}
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
		// Edit, Delete buttons
		if (
			// if users owns element or if user is admin display edit & delete
			$_SESSION['id_user'] == $row['id_user'] ||
			$_SESSION['id_group'] == 1
		) {
			echo '<p>
				<button name="page[edit][req]"
					value="'.$row['id_page'].'">Edit</button>'."\n".
				'<button name="page[delete][req]"
					value="'.$row['id_page'].'">Delete</button></p>'."\n";
		}
		?>
		</form>
<?php
	return;
}

/**
 * Display page add.
 * @return null
 */
function display_page_add() {
?>
<form action="<?php echo current_page(true); ?>" method="post">
	<input name="page[add][title]" type="text" class="page_title"><br><br>
	<textarea name="page[add][body]" rows="18" cols="100" id="textarea">
		</textarea><br>
	<button name="page[add][submit]" value="Submit">Submit</button>
</form>
<?php
	return;
}

/**
 * Display page edit.
 * @return null
 */
function display_page_edit() {
	global $page;
	$result = mysql_query(
		'select *
		from pages
		where id_page='.$page['edit']['req']
	);
	queryCount();
	$row = mysql_fetch_array($result);
?>
<form action="<?php echo current_page(true); ?>" method="post">
	<input name="page[edit][title]" type="text" class="page_title"
		value="<?php echo $row['title'] ?>"><br><br>
	<textarea name="page[edit][body]" rows="18" cols="100" id="textarea">
		<?php echo $row['body'] ?></textarea><br>
	<button name="page[edit][submit]"
		value="<?php echo $row['id_page'] ?>">Submit</button>
</form>
<?php
	return;
}
?>
</div>
</div>
