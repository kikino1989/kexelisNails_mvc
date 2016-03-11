<?php
class DBContext {
	
	private $dataBase;
	private $entity;
	private $reflectedClass;
	private $className;
	private $tableName;
	private $fields;
	
	public $querybuilder;
	
	function __construct(PDO $dataBase, $entity = null) {
		
		$this->dataBase = $dataBase;
		$this->querybuilder = new QueryBuilder($dataBase);
		
		if($entity != null){
			
			$this->entity = $entity;
			$this->reflectedClass = new ReflectionClass($entity);
			$this->className = $this->reflectedClass->getName();
			$this->tableName = strtolower($this->className);
			$this->fields = $this->reflectedClass->getProperties();
		}	
	}
	
	/**
	 * @desc : loads entry from database
	 * @return object of especified type 
	 */
	public function read($condition = ""){
		$stmt = $this->dataBase->query("SELECT * FROM $this->tableName $condition");
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
		return $stmt->fetch();
	}
	
	/**
	 * @desc : loads entries from database
	 * @return array(object of especified type )
	 */
	public function readMany($condition = ""){
		$stmt = $this->dataBase->query("SELECT * FROM $this->tableName $condition");
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
		return $stmt->fetchAll();
	}
	
	/**
	 * $desc : insert new entry to table
	 * @throws PDOException
	 */
	public function create() {
	
		// create query to excecute on object.
		$values = array();
		$query = "INSERT INTO $this->tableName (";
		foreach (array_slice($this->fields, 1) as $field){
			$query .= $field->getName().',';
			$values[] = $field->getValue($this->entity);
		}
		
		// get right amount of parameters for the query
		$query = rtrim($query,',');
		$query .= ") VALUES(";
		foreach($values as $value){
			$query.= '?,'; 
		}
		$query = rtrim($query,',');
		$query .= ')';
		
		
		// excecute query.
		try {
			$stmt = $this->dataBase->prepare ($query);
			$stmt->execute ($values);
			$stmt->closeCursor ();
		} catch ( PDOException $e ) {
			throw $e;
		}
	}
	
	/**
	 * @desc : deletes data from the database, if condition is not pass, it deletes by id.
	 */
	public function delete($condition = null){
		// set the condition to a default value.
		$id = $this->reflectedClass->getProperty('id')->getValue($this->entity);
		$condition = ($condition === null)?"WHERE id = $id":$condition;
		
		$query = "DELETE FROM $this->tableName $condition";
		$this->dataBase->query($query);
	}
	
	/**
	 * @desc : updates entry on a table, if condition is not pass, it updates by id.
	 * @param string $condition
	 * @throws PDOException
	 */
	public function update($condition = null){
		// set the condition  to a default value
		$id = $this->reflectedClass->getProperty('id')->getValue($this->entity);
		$condition = ($condition === null)?"WHERE id = $id":$condition;
		
		// create query to excecute on object.
		$values = array();
		$query = "UPDATE $this->tableName SET ";
		foreach (array_slice($this->fields, 1) as $field){
			$query .= $field->getName().' = ?,';
			$values[] = $field->getValue($this->entity);
		}
		$query = rtrim($query,',');
		$query .= " $condition";
		
		
		// excecute query.
		try {
			$stmt = $this->dataBase->prepare ($query);
			$stmt->execute ($values);
			$stmt->closeCursor ();
		} catch ( PDOException $e ) {
			throw $e;
		}
	}
	
	/**
	 * @desc : returns whether an entry exist or not
	 * @param string $condition
	 * @return boolean
	 */
	public function exist($condition){
		$result = $this->dataBase->query ( "SELECT * FROM $this->tableName $condition" );
		return ($result->rowCount() === 0)?false:true;
	}
	
	/**
	 * @desc : return entity.
	 */
	public function getEntity(){
		return $this->entity;
	}
}