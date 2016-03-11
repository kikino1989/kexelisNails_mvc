<?php
class Comment_for_employee extends Model{
	
	public $id;
	public $ownerid;
	public $employeeid;
	public $text;
	public $date;
	
	function __construct( $ownerid = null, $employeeid = null, $text = null, $date = null) {
		parent::__construct();
		
		$this->ownerid = $ownerid;
		$this->employeeid = $employeeid;
		$this->text = $text;
		$this->date = $date;
	}
}