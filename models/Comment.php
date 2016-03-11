<?php
class Comment extends Model{
	
	public $id;
	public $ownerid;
	public $entityid;
	public $text;
	public $date;
	
	function __construct( $ownerid = null, $entityid = null, $text = null, $date = null) {
		parent::__construct();
		
		$this->ownerid = $ownerid;
		$this->entityid = $entityid;
		$this->text = $text;
		$this->date = $date;
	}
}