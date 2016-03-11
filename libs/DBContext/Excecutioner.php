<?php
class Excecutioner extends QueryBuilder {
	
	function __construct($dataBase, $customQuery) {
		parent::__construct($dataBase, $customQuery);
	}
	
	/**
	 * @desc : executes the query.
	 * @param bool $fetchMany whether the excecutioner returns an array of a single value.
	 * @param string $class the name of the class if fetch is set to pdo::fetchclass.
	 * @param string $fetchMode the pdo fetch mode .
	 * @return array or single value of especified type.
	 */
	public function execute($fetchMany = false, $fetchMode = PDO::FETCH_OBJ, $class = null){
		
		$stmt = $this->dataBase->query($this->customQuery);
		if($class !== null){
			$stmt->setFetchMode($fetchMode, $class);
		}else{
			$stmt->setFetchMode($fetchMode);
		}
		if ($fetchMany === false) 
			return $stmt->fetch();
		else 
			return $stmt->fetchAll();
	}
	
	/**
	 * @desc : executes the query for UPDATE, INSERT AND DELETE
	 * @return int the number of afected rows.  
	 */
	public function exe(){
		$stmt = $this->dataBase->query($this->customQuery);
		return $stmt->rowCount();
	}
}