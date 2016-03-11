<?php
class Base {
	
	protected $pre;
	
	function __construct() {
		$this->pre = "";
	}
	
	/**
	 * @desc : returns proper link
	 * @param string $_link
	 * @return string
	 */
	public function path($_link){
		return $this->pre.$_link;
	}
	
	/**
	 * @desc : returns sets the proper path for the file
	 * @param array(string) $size
	 */
	public function setPath($size){
		if ($size > 1) {
			for($i = 0; $i < $size - 1; $i ++) {
				$this->pre .= "../";
			}
		}else {
			$this->pre = "";
		}
	}
	
}