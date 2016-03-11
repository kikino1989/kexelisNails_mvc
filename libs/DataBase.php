<?php
class DataBase extends PDO{
	function __construct() {
		parent::__construct("mysql:host=localhost;dbname=kexelisnails", "root", "");
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}