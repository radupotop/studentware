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
?>
