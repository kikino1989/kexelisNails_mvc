<?php
class Error extends Controller{
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * @desc : show the page not found error or a custom error sent from the controller
	 * @param string $err
	 * @return string
	 */
	function index($err = false) {
		
		return ($err !== false)? $err[0]: "Opps, page not found";
	}
}