<?php
class Selection extends QueryBuilder{
	
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : sets the table for the query.
	 * @example "user"
	 * @param string $selection the name or names of the table or tables
	 * @return StdClass|mixed
	 */
	public function from($table){
		$this->customQuery .= "FROM $table ";
		return new Source($this->dataBase, $this->customQuery);
	}
}