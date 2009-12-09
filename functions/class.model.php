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
			$query .= sprintf('where %s = "%s" ', $field, esc($value));
		if($limit)
			$query .= sprintf('limit %s ', $limit);

		$result = mysql_query($query);
		queryCount();
		while($row = mysql_fetch_assoc($result))
			$data[$row[$pk]] = $row;
		return $data;
	}

	/**
	 * Add data to table.
	 */
	function add($table, $data=array()) {
		foreach($data as $key => $value) {
			$keyList .= sprintf('%s, ', $key);
			$valueList .= sprintf('"%s", ', esc($value));
		}
		$keyList = rtrim($keyList, ', ');
		$valueList = rtrim($valueList, ', ');
		$query = sprintf('insert into %s (%s) values (%s)', $table, $keyList, $valueList);
		$result = mysql_query($query);
		queryCount();
		if($result)
			$ret = true;
		else
			$ret = false;
		return $ret;
	}
}
?>
