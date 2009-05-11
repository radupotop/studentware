<?php
/**
 * @file
 * Functions file, also used to autoload classes.
 */

/**
 * Init.
 */
{
	mysql_connect($db['host'], $db['user'], $db['pass']);
	mysql_set_charset($db['char']);
	mysql_select_db($db['name']);
	session_start();
}

/**
 * Autoload needed classes from corresponding files.
 *
 * @param string $class_name
 * @return null
 */
function __autoload($class_name) {
	$class_name = strtolower($class_name);
	require_once 'class.' . $class_name . '.php';
	return;
}

/**
 * Trim input string to specified length.
 *
 * @param string $title - input string
 * @param int $len - length
 * @return string $title - trimmed string followed by '...'
 */
function trim_title($title, $len) {
	if (strlen($title) > $len) {
		$title = substr($title, 0, $len) . '...';
	}
	return $title;
}

/**
 * Get the GET string of the current page.
 * This is used by forms to stay on the same page after submitting.
 *
 * @param bool $escape - whether to escape ampersands or not
 * @return string $get_string - complete GET string
 */
function current_page($escape) {
	if($escape) {
		$amp = '&amp;';
	} else {
		$amp = '&';
	}
	$keys = array_keys($_GET);
	$values = array_values($_GET);
	$count = count($_GET);
	$get_string = '?';
	for ($i=0; $i<$count; $i++) {
		$get_string = $get_string . $keys[$i] . '=' . $values[$i];
		if ($i<$count-1) {
			$get_string = $get_string . $amp;
		}
	}
	if ($get_string == '?') {
		$get_string = '.';
	}
	return $get_string;
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
 * Check if current user has permissions for specified page.
 *
 * @param string $page - page to get permissions for
 * @return int $perm - permission number
 */
function get_permissions($page) {
	return $perm;
}

?>
