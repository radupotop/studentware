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
	$queryCount = 0;
	chdir($site['path']);
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
 * Get the query string of the current page.
 * This is used by forms to stay on the same page after submitting.
 *
 * @param bool $escape - whether to escape ampersands or not
 * @return string $get_string - complete query string
 */
function current_page($escape=true) {
	$get_string = '?' . $_SERVER['QUERY_STRING'];
	if ($escape)
		$get_string = preg_replace('/&/', '&amp;', $get_string);
	if ($get_string == '?')
		$get_string = '.';
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
 * Escape data to be inserted into db.
 *
 * @param $value - value to be escaped
 * @return $value - escaped value
 */
function esc($value) {
	if (get_magic_quotes_gpc() == false) {
		$value = mysql_real_escape_string($value);
  	}
	return $value;
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

/**
 * Log message to a file.
 * @param string $msg - message to log
 */
function _log ($msg) {
	global $app;
	if (
		$app['log']['enabled'] &&
		$log = fopen($app['log']['path'], 'a')
	) {
		fwrite($log, date('Y-m-d H:i:s - ').$msg."\n");
		fclose($log);
	}
	return;
}

/**
 * Count SQL queries.
 */
function queryCount() {
	global $queryCount;
	$queryCount++;
	return;
}

?>
