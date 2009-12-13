<?php
/**
 * @class Model
 */
class Model {
	public $queryCount = 0; // $this->queryCount++;

	/**
	 * Escape data to be inserted into db.
	 *
	 * @param string $value - value to be escaped
	 * @return string $value - escaped value
	 */
	function esc($value) {
		if (!get_magic_quotes_gpc())
			$value = mysql_real_escape_string($value);
		return $value;
	}

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
			$query .= sprintf('where %s = "%s" ', $field, $this->esc($value));
		if($limit)
			$query .= sprintf('limit %s ', $limit);

		$result = mysql_query($query);
		$this->queryCount++;
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
		foreach($data as $key => $val) {
			if($key == 'pass')
				$val = sha1($val);
			$keyList .= sprintf('%s, ', $key);
			$valList .= sprintf('"%s", ', $this->esc($val));
		}
		$keyList = rtrim($keyList, ', ');
		$valList = rtrim($valList, ', ');

		$query = sprintf('insert into %s (%s) values (%s)',
			$table, $keyList, $valList);
		$result = mysql_query($query);
		$this->queryCount++;
		return $result;
	}

	/**
	 * Edit data from table.
	 *
	 * @param string $table
	 * @param array $data
	 * @param int $id
	 */
	function edit($table, $data=array(), $field, $value) {
		$query = sprintf('update %s set ', $table);
		foreach ($data as $key => $val)
			if($val) {
				if($key == 'pass')
					$val = sha1($val);
				$query .= sprintf('%s = "%s", ', $key, $this->esc($val));
			}
		$query = rtrim($query, ', ');
		$query .= sprintf(' where %s = "%s"', $field, $this->esc($value));

		$result = mysql_query($query);
		$this->queryCount++;
		return $result;
	}

	/**
	 * Delete data from table.
	 *
	 * @param string $table
	 * @param string $field
	 * @param string $value
	 * @return bool $result
	 */
	function delete($table, $field, $value) {
		$query = sprintf('delete from %s where %s = "%s"',
			$table, $field, $this->esc($value));
		$result = mysql_query($query);
		$this->queryCount++;
		return $result;
	}
}
?>
