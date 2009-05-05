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
		<td>
		<input title="Title" type="text" name="upload[title]" id="upload_title">
		</td>
		<td colspan="2">
		<input title="File" type="file" name="upload">
		<input type="submit" name='upload[submit]' value="Upload">
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
	</tr>
	</thead>
	<tbody>
<?php
	$result = mysql_query(
		'select files.id_file, files.id_user, files.date_modified,
		files.title, files.filename, users.first_name, users.fam_name
		from files
		join users
		on files.id_user = users.id_user
		order by date_modified desc'
	);
	while ($row = mysql_fetch_array($result)) {
		echo
		'	<tr>' .
		'		<td><a href="' . $site['files'] . $row['filename'] . '">' .
					$row['title'] . '</a></td>' .
		'		<td>' . $row['first_name'] . ' ' . $row['fam_name'] . '</td>' .
		'		<td>' . Date::from_sql($row['date_modified']) . '</td>' .
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
