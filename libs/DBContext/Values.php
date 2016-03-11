<?php
class Values extends QueryBuilder {
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}

	/**
	 * @desc : sets the values to be inserted.
	 * @example "1,2,3,'example name',12"
	 * @param string $values
	 * @return Condition
	 */
	public function vals($values){
		$this->customQuery .= "VALUES ($values) ";
		return new Excecutioner($this->dataBase, $this->customQuery);
	}
}