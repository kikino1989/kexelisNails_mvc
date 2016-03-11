<?php
class Employee_schedule extends Model{
	public $id;
	public $employeeid;
	public $starttime;
	public $endtime;
	public $day;
	public $day_number;
	
	function __construct($employeeid = null, $starttime = null, $endtime = null, $day = null, $day_number = null) {
		parent::__construct();
		
		$this->employeeid = $employeeid;
		$this->starttime = $starttime;
		$this->endtime = $endtime;
		$this->day = $day;
		$this->day_number = $day_number;
	}
}
