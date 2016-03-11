<?php
class FieldsToUpdate extends QueryBuilder {
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : sets the fields for the query
	 * @example "id = 1, firstname = julia"
	 * @param array $fields
	 * @return Values
	 */
	public function set($set){
		$this->customQuery .= "SET $set ";
		return new Source($this->dataBase, $this->customQuery);
	}
}