<?php
/**
 * @file
 * Input files.
 */

/**
 * Get filename of file.
 * @param string $file - file
 * @return string $filename - its filename
 */
function filename($file) {
	$len = - strlen($file) + strrpos($file, '.');
	$filename = substr($file, 0, $len);
	return $filename;
}

/**
 * Get extension of file.
 * @param string $file - file
 * @return string $ext - extension
 */
function extension($file) {
	$ext = substr($file, strrpos($file, '.'));
	return $ext;
}

/**
 * Rename filename.ext to hash.ext
 * @param string $path - path to file
 * @param string $file - file
 * @return string $hashed - file renamed to its hash
 */
function rename_to_hash($path, $file) {
	$hash = hash_file('sha1', $path . $file);
	$ext = substr($file, strrpos($file, '.'));
	$hashed = $hash . $ext;
	rename($path . $file, $path . $hashed);
	return($hashed);
}

/**
 * Input upload.
 * @return bool - whether upload succeded or not
 */
function input_upload() {
	$title = filter_var($_POST['upload']['title'], FILTER_SANITIZE_ENCODED);
	if($_SESSION['login'] && $title) {
	global $site;
	if (
		($_FILES['upload']['error'] == 0)
	&&	($_FILES['upload']['size'] < 31000000)
	&&	(
		($_FILES['upload']['type'] == 'application/zip')
	||	($_FILES['upload']['type'] == 'image/png')
	)
	) {
		move_uploaded_file($_FILES['upload']['tmp_name'],
			$site['files'] . $_FILES['upload']['name']);
		$hash = rename_to_hash($site['files'], $_FILES['upload']['name']);
		mysql_query(
			'insert into files
			values (null, "' . $_SESSION['id_user'] . '",
			"' . Date::to_sql('now') . '", "' . $title . '", "' . $hash . '")'
		);
		return true;
	}
	else
		return false;
	}
}
input_upload();

/**
 * Delete files. First delete file on disk then erase record from database.
 * @return null
 */
function input_delete() {
	global $site;
	if ($_SESSION['login'] && $_POST['delete']) {
		$delete = filter_input(INPUT_POST, 'delete', FILTER_VALIDATE_INT);
		$result = mysql_query(
			'select filename
			from files
			where id_file=' . $delete
		);
		$row = mysql_fetch_array($result);
		unlink($site['files'] . $row['filename']);
		mysql_query(
			'delete from files
			where id_file=' . $delete
		);
	}
	return;
}
input_delete();

/**
 * Handles downloads - force the browser to display the save dialog.
 * @return null
 */
function input_download() {
	global $site;
	$download = filter_input(INPUT_GET, 'download', FILTER_VALIDATE_INT);
	if($download) {
		$result = mysql_query(
			'select *
			from files
			where id_file=' . $download
		);
		$row = mysql_fetch_array($result);
		$download_name = $row['title'] . extension($row['filename']);
		$file = $site['files'] . $row['filename'];
		//header('Content-type: ' . mime_content_type($file));
		header('Content-Disposition: attachment;
			filename="' . $download_name . '"');
		readfile($file);
	}
	return;
}
input_download();


?>
