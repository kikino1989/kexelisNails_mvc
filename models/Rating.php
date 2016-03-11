<?php
class Rating extends Model{
	
	public $id;
	public $ownerid;
	public $entityid;
	public $rate;
	
	function __construct($ownerid = null, $entityid = null, $rate = null) {
		parent::__construct();
		
		$this->ownerid = $ownerid;
		$this->entityid = $entityid;
		$this->rate = $rate;
	}
}