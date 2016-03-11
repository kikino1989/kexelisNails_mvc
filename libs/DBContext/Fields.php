<?php
class Fields extends QueryBuilder {
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : sets the fields for the query
	 * @param string $fields the fields to be selected 
	 * @example "id,firstname,lastname"
	 * @return Values
	 */
	public function selectedFields($fields){
		$this->customQuery .= "($fields) ";
		return new Values($this->dataBase, $this->customQuery);
	}
}