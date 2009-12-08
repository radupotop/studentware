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
	function view($table, $field=null, $value=null, $limit=null) {
		$pk = 'id_'.substr($table, 0, -1);

		$query = sprintf('select * from %s ', $table);
		if($field && $value)
			$query .= sprintf('where %s like "%s" ', $field, esc($value));
		if($limit)
			$query .= sprintf('limit %s ', $limit);

		$result = mysql_query($query);
		queryCount();
		while($row = mysql_fetch_assoc($result))
			$data[$row[$pk]] = $row;
		return $data;
	}
}
?>
