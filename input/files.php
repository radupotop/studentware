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
	if($_SESSION['login'] && $_POST['upload']['submit']) {
	//$title = filter_input(INPUT_POST, '[upload][title]', FILTER_SANITIZE_ENCODED);
	$title = $_POST['upload']['title'];
	global $site;
	if (
		($_FILES['upload']['error'] == 0)
	&&	($_FILES['upload']['size'] < 31000000)
	&&	(file_exists($_FILES['upload']['name']) == 0)
	&&	ereg("^[^.]+.*$", $_FILES['upload']['name'])

	&&	(
		($_FILES['upload']['type'] == 'application/zip')
	||	($_FILES['upload']['type'] == 'image/png')
	)
	) {
		move_uploaded_file($_FILES['upload']['tmp_name'],
			$site['files'] . $_FILES['upload']['name']
		);
		$hash = rename_to_hash($site['files'], $_FILES['upload']['name']);
		//if(file_exists($site['files'] . $hash) == false) {
		mysql_query(
			'insert into files
			values (null, "' . $_SESSION['id_user'] . '",
			"' . Date::to_sql('now') . '", "' . $title . '", "' . $hash . '")'
		);
		//}
		return true;
		echo $title;
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


?>
