<?php
class Image extends Model {
	
	public $id;
	public $path;
	public $name;
	public $ownerid;
	
	function __construct( $path = null, $name = null, $ownerid = null) {
		parent::__construct();
		
		$this->name = $name;
		$this->path = $path;
		$this->ownerid = $ownerid;
	}
}