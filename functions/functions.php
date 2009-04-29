<?php
/**
 * @file
 * Functions file, also used to autoload classes.
 */

/**
 * Autoload needed classes from corresponding files.
 * File format is class.class_name.php
 * class_name must be lowercase
 *
 * @param string $class - class name to be loaded
 * @return null
 */
function __autoload($class) {
	$class = strtolower($class);
	require_once 'class.' . $class . '.php';
	return;
}

/**
 * Trim input string to specified length.
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

?>
