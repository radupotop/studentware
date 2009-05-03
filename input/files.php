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
	$hash = hash_file('md5', $path . $file);
	$ext = substr($file, strrpos($file, '.'));
	$hashed = $hash . $ext;
	rename($path . $file, $path . $hashed);
	return($hashed);
}

/**
 * Display upload.
 * @return bool - whether upload succeded or not
 */
function input_upload() {
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
			$site['files'] . sha1($_FILES['upload']['name']) .
				extension($_FILES['upload']['name'])
		);
		return true;
	}
	else
		return false;
}
input_upload();

?>
