<?php
require_once 'conf.php';
/**
 * @desc : load classes for the project
 */
spl_autoload_register(function($include){

	global $dirs;
	$class = $include;
	foreach ($dirs as $dir){
		
		$include = str_replace("//",DIRECTORY_SEPARATOR,$dir.DIRECTORY_SEPARATOR.$include.".php");
		if(file_exists($include)){
				
			require_once($include);
		}
		$include = $class;
	}
});
	
/**
 * @desc : starting point of the applicaton
 */

function start(){
	
	// get the url, sanitize it to be loaded.
	$url = (isset($_GET ['url']))?$_GET ['url']:null;
	$url = rtrim($url, '/');
	//$url = filter_var($url, FILTER_SANITIZE_URL); eliminates especial characters from the url.
	$url = explode ( '/', $url );
	$size = count($url);
	
	$view = null;
	$controller = null;
	
	if($url === null || $url[0] === ""){
		
		// load index in case that not controller or action is given
		$controller = new Index();
		$view = new View('Index/index',$controller->index());
		
	}elseif(file_exists("controllers/".ucfirst($url[0]).".php")){
		
		// get class, and initialize
		$Controller_Class = ucfirst($url[0]);
		$controller = new $Controller_Class;
		
		//set proper path for links
		$controller->setPath($size);
		
		//call index action as default if not action is given
		if(!isset($url[1]) || $url[1] === ""){
			
			$view = new View("$Controller_Class/index",$controller->index());
		}else{
			
			//get method
			$action = $url[1];
			if(method_exists($controller, $action)){
				if(isset($url[2])){
				
					// get arg list
					$args = array_slice($url, 2);
					$view = new View("$Controller_Class/$action",$controller->$action($args));
				}else{
					$view = new View("$Controller_Class/$action",$controller->$action());
				}
			}else{
				$controller = new Error();
				$view = new View('Error/index', $controller->index());
			}
			
		}
	}else{
		$controller = new Error();
		$view = new View('Error/index', $controller->index());
	}
	
	//set proper path for links
	$view->setPath($size);
	
	//render view if not ajax calls or call to procedures are executed
	if($view !== null )$view->render();
}

start();