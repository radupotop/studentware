<?php
/**
 * @file
 * Functions file, also used to load classes.
 */

/**
 * HTML input filter.
 */
require('class.inputfilter.php');
$allowed_tags = array('strong', 'em', 'span', 'br', 'cite');
$html_filter = new InputFilter($allowed_tags);

/**
 * Converts dates from/to SQL format.
 * @class Date
 */
class Date {
	/**
	 * Convert date from SQL format to 'd M Y, H:i' format.
	 * @param string $date - date in SQL format
	 * @return string $formatted - date in 'd M Y, H:i' format
	 */
	function from_sql($date) {
		$unix = strtotime($date);
		$formatted = date('d M Y, H:i', $unix);
		return $formatted;
	}
	/**
	 * Convert date from any format supported by PHP strtotime() to SQL format.
	 * @param string $date - date in any format
	 * @return string $formatted - date in SQL format
	 */
	function to_sql($date) {
		$unix = strtotime($date);
		$formatted = date('Y-m-d H:i:s', $unix);
		return $formatted;
	}
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
