<?php
/**
 * @file
 * Display files.
 */

/**
 * Display upload.
 * @return null
 */
function display_upload() {
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
		<input type="file" name="upload" id="upload_file" size="18">
		<input type="submit" name="upload[add][submit]" value="Upload">
		</td>
	</tr>
<?php
	}
}

/**
 * Display files.
 * @return null
 */
function display_files() {
	global $site;
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

display_upload();
?>
	</tbody>
</table>
</form>
<?php
	return;
}
display_files();
?>
