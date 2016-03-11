<?php
class QueryBuilder {
	protected $customQuery;
	public $dataBase;
	
	function __construct($dataBase, $customQuery = "") {
		$this->dataBase = $dataBase;
		$this->customQuery = $customQuery;
	}
	
	/**
	 * @desc : sets the selection for the query.
	 * @example selete($args)->from($table)->where($condition)->options($options)->execute($fetchMany, $class, fetchMode);
	 * @param string $selection
	 * @return StdClass|mixed
	 */
	public function select($selection){
		$this->customQuery = "SELECT $selection ";
		return new Selection($this->dataBase, $this->customQuery);
	}
	
	/**
	 * @desc : set the table for the query where the data will be inserted
	 * @example insert($table)->selectedFields($fields)->vals($values)->exe();
	 * @param unknown $table
	 * @return Fields
	 */
	public function insert($table){
		$this->customQuery = "INSERT INTO $table ";
		return new Fields($this->dataBase, $this->customQuery);
	}
	
	/**
	 * @desc : set the table for the query where the data will be updated
	 * @example update($table)->set($values)->where($condition)->options($options)->exe();
	 * @param unknown $table
	 * @return Fields
	 */
	public function update($table){
		$this->customQuery = "UPDATE $table ";
		return new FieldsToUpdate($this->dataBase, $this->customQuery);
	}
	
	/**
	 * @desc : set the table for the query where the data will be deleted
	 * @example delete($table)->where($condition)->options($options)->exe();
	 * @param unknown $table
	 * @return Fields
	 */
	public function delete($table){
		$this->customQuery = "DELETE FROM $table ";
		return new Source($this->dataBase, $this->customQuery);
	}
}