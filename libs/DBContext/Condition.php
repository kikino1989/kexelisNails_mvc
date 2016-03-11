<?php
class Condition extends  QueryBuilder {

	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : sets any extra parameters for the query.
	 * @example "ORDER BY id DESC"
	 * @param string $selection
	 * @return StdClass|mixed
	 */
	public function options($options = ""){
		$this->customQuery .= $options;
		return new Excecutioner($this->dataBase, $this->customQuery);
	}
}