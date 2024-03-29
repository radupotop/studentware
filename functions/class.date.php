<?php
/**
 * Converts dates from/to SQL format.
 * @class Date
 */
class Date {
	var $date;

	/**
	 * Convert date from SQL format to 'd M Y, H:i' format.
	 * @param string $date - date in SQL format
	 * @return string $formatted - date in 'd M Y, H:i' format
	 */
	static function from_sql($date) {
		$unix = strtotime($date);
		$formatted = date('d M Y, H:i', $unix);
		return $formatted;
	}

	/**
	 * Convert date from any format to UNIX format
	 * @param string $date - date in any format
	 * @return string $unix - date in UNIX format
	 */
	static function to_unix($date) {
		$unix = strtotime($date);
		return $unix;
	}

	/**
	 * Convert date from any format supported by PHP strtotime() to SQL format.
	 * @param string $date - date in any format
	 * @return string $formatted - date in SQL format
	 */
	static function to_sql($date) {
		$unix = strtotime($date);
		$formatted = date('Y-m-d H:i:s', $unix);
		return $formatted;
	}
}
?>
