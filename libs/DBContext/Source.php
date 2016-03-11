<?php
class Source extends QueryBuilder{

	const JOIN = "INNER JOIN"; 
	const LEFT_JOIN = "LEFT JOIN";
	const RIGHT_JOIN = "RIGHT JOIN";
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : sets the conditions for the query.
	 * @example "id = 1 AND firstname = jose"
	 * @param string $selection
	 * @return StdClass|mixed
	 */
	public function where($condition = ""){
		$this->customQuery .= ($condition === "")?"$condition":"WHERE $condition";
		return new Condition($this->dataBase, $this->customQuery);
	}	
	
	/**
	 * @desc : sets the join condition for the query
	 * @param string $joinTable
	 * @param string $condition
	 * @param Source::join | Source::left_join | Source::right_join$ join
	 * @return Condition
	 */
	public function join($joinTable, $condition, $join = self::JOIN){
		$this->customQuery .= ($condition === "")?"$condition":"$join $joinTable ON $condition";
		return new Condition($this->dataBase, $this->customQuery);
	}
}