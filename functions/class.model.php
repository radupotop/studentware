<?php
/**
 * @class Model
 */
class Model {
	/**
	 * Get data from table.
	 *
	 * @param string $table
	 * @return array $data
	 */
	function view($table) {
		$pk = 'id_'.substr($table, 0, -1);
		$query = sprintf('select * from %s', $table);
		$result = mysql_query($query);
		queryCount();
		while($row = mysql_fetch_assoc($result))
			$data[$row[$pk]] = $row;
		return $data;
	}
}
?>
