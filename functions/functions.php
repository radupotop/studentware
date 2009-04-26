<?php
// html input filter
require('class.inputfilter.php');
$allowed_tags = array('strong', 'em', 'span', 'br', 'cite');
$html_filter = new InputFilter($allowed_tags);

class date {
	function from_sql($date) {
		$unix = strtotime($date);
		$formatted = date('d M Y, H:i', $unix);
		return $formatted;
	}
	function to_sql($date) {
		$unix = strtotime($date);
		$formatted = date('Y-m-d H:i:s', $unix);
		return $formatted;
	}
}

function trim_title($title, $len) { // trim title to specified length
	if (strlen($title) > $len) {
		$title = substr($title, 0, $len) . '...';
	}
	return $title;
}

function current_page($escape) {
	// get current page GET string with escaped ampersand or not
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
