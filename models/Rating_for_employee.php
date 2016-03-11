<?php
class Rating_for_employee extends Model{
	
	public $id;
	public $ownerid;
	public $employeeid;
	public $rate;
	
	function __construct( $ownerid = null, $employeeid = null, $rate = null) {
		parent::__construct();
		
		$this->ownerid = $ownerid;
		$this->employeeid = $employeeid;
		$this->rate = $rate;
	}
}