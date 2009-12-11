<?php
/**
 * @class Model
 */
class Model {

	/**
	 * Get a table's PK name.
	 *
	 * @param string $table
	 * @return string $pk
	 */
	function pk($table) {
		$pk = 'id_'.substr($table, 0, -1);
		return $pk;
	}

	/**
	 * Get data from table.
	 *
	 * @param string $table
	 * @return array $data
	 */
	function view($table, $field=null, $value=null, $limit=null) {
		$pk = $this->pk($table);

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
	 *
	 * @param string $table
	 * @param array $data
	 * @return bool $result
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
		return $result;
	}

	/**
	 * Edit data from table.
	 *
	 * @param string $table
	 * @param array $data
	 * @param int $id
	 */
	function edit($table, $data=array(), $id=int) {
		$pk = $this->pk($table);

		$query = sprintf('update %s set ', $table);
		foreach ($data as $key => $value)
			$query .= sprintf('%s = "%s", ', $key, esc($value));
		$query = rtrim($query, ', ');
		$query .= sprintf(' where %s = %s', $pk, $id);

		$result = mysql_query($query);
		queryCount();
		return $result;
	}

	/**
	 * Delete data from table.
	 *
	 * @param string $table
	 * @param int $id
	 * @return bool $result
	 */
	function delete($table, $id=int) {
		$pk = $this->pk($table);
		$query = sprintf('delete from %s where %s = %s', $table, $pk, $id);
		$result = mysql_query($query);
		queryCount();
		return $result;
	}
}
?>