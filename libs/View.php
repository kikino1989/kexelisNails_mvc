<?php
class View extends Base{
	
	// view class properties
	private $view;
	public $meta;
	public $data;
	public $title;
	public $js;
	public $css;
	
	/**
	 * @desc : setting object properties.
	 * @param string $view
	 * @param array(string) $data
	 */
	public function __construct($view, $data=null){
		parent::__construct();
		$this->view = $view;
		$this->data = $data;
		$this->meta = $this->loadMeta();
		$this->title = $this->meta['title'];
		unset($this->meta['title']);
		
		$this->js = $this->loadJS($this->view);
		$this->css = "$this->view.css";
	}
	
	/**
	 * @desc : load meta data for specified view.
	 * @return array(string) with the meta data. 
	 */
	private function loadMeta(){
		
		$meta = null;
		$filename = "views/$this->view/".lcfirst($this->view).'.meta.php';
		if(file_exists($filename)){
			
			require_once($filename);
		}
		return $meta;
	}
	
	/**
	 * @desc : loads script 
	 * @param string $filename
	 * @param sctring $script
	 * @return string 
	 */
	private function loadJS($script){
		if(file_exists("utils/js/$script.js")){
			return "utils/js/$script.js";
		}
		return null;
	} 
	
	/**
	 * @desc : require specified view
	 */
	public function render(){
		require_once("views/Layout/layout.php");
	}
	
	/**
	 * @desc : display the proper page if exists.
	 */
	public function page(){
		
		if(file_exists('views/'.$this->view.'.php')){
			require_once 'views/'.$this->view.'.php';
		}
	}
}