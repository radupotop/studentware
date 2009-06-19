<?php
/**
 * @file
 * Display files.
 */

/**
 * Display files add.
 * @return null
 */
function display_files_add() {
	if($_SESSION['login']) {
?>
	<tr>
		<td colspan="2">
		<label for="upload_title">Title</label>
		<input type="text" name="upload[add][title]" id="upload_title"
			size="40">
		</td>
		<td colspan="2">
		<label for="upload_file">File</label>
		<input type="file" name="upload_add" id="upload_file" size="18">
		<input type="submit" name="upload[add][submit]" value="Upload">
		</td>
	</tr>
<?php
	}
	return;
}

/**
 * Display files edit.
 * @return null
 */
function display_files_edit() {
	global $upload;
	$result = mysql_query(
		'select title
		from files
		where id_file = '.$upload['edit']['req']
	);
	$row = mysql_fetch_array($result);
	if($_SESSION['login'] && $upload) {
?>
	<tr class="editing">
		<td colspan="2">
		<label for="upload_edit_title">Title</label>
		<input type="text" name="upload[edit][title]" id="upload_edit_title"
			size="40" value="<?php echo $row['title'] ?>">
		</td>
		<td colspan="2">
		<label for="upload_edit_file">File</label>
		<input type="file" name="upload_edit" id="upload_edit_file" size="18">
		<button name="upload[edit][submit]"
			value="<?php echo $upload['edit']['req'] ?>">Edit file</button>
		</td>
	</tr>
<?php
	}
	return;
}

/**
 * Display files.
 * @return null
 */
function display_files() {
	global $upload;
?>
<h2>Files</h2>
<form action="<?php echo current_page(true); ?>" method="post"
	enctype="multipart/form-data">
<table>
	<thead>
	<tr>
		<th>Title</th>
		<th>Uploaded by</th>
		<th>Date</th>
		<?php if ($_SESSION['login']) { ?>
		<th>Manage</th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
	$result = mysql_query(
		'select files.id_file, files.id_user, files.date_modified, files.title,
		files.filename, users.id_group, users.first_name, users.fam_name
		from files
		join users
		on files.id_user = users.id_user
		order by date_modified desc'
	);
	while ($row = mysql_fetch_array($result)) {
		if($row['id_file'] == $upload['edit']['req']) {
			display_files_edit();
		} else {
		echo
		'	<tr>' .
		'		<td><a href="?page=files&amp;download=' .
				$row['id_file'] . '">' . $row['title'] . '</a></td>' .
		'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' .
		'		<td>' . Date::from_sql($row['date_modified']) . '</td>';
		if ($_SESSION['login']) {
			echo
		'		<td>';
			if(
				$_SESSION['id_user'] == $row['id_user'] ||
				$_SESSION['id_group'] == 1
			) {
				echo
		'		<button name="upload[edit][req]" value="' . $row['id_file'] .
						'">Edit</button>' .
		'		<button name="upload[delete][req]" value="' . $row['id_file'] .
						'">Delete</button>';
			}
			echo
		'		</td>';
		}
		echo
		'	</tr>';
	}
	}

display_files_add();
?>
	</tbody>
</table>
</form>
<?php
	return;
}
display_files();
?>
