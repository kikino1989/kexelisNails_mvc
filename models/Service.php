<?php
class Service extends Model{
	
	public $id;
	public $name;
	public $duration;
	public $estimatedprice;
	public $description;
	
	function __construct( $name = null, $duration = null, $estimatedprice = null, $description = null) {
		parent::__construct();
		
		$this->name = $name;
		$this->duration = $duration;
		$this->estimatedprice = $estimatedprice;
		$this->description = $description;
	}
	
	
}