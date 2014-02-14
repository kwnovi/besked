<?php
require_once(dirname(__FILE__).'\users\route.php');
require_once(dirname(__FILE__).'\users\actions.php');

//require_once('messages/route.php');
//require_once('discussions/route.php');


// singleton
class Router{
	
	private static $instance;
	//private static $routes_map;
	
	protected function __construct(){}

	public static function get_instance(){
		if(!isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	public static function get_route($routes, $url){
		echo $url;
		foreach ($routes as $pattern => $handler) {
			var_dump(preg_match($pattern, $url));
			if(preg_match($pattern, $url)){
				echo 'found';
				call_user_func($handler);
				exit;
			}
		}
				echo 'not found';
		self::not_found();
	}

	private static function not_found(){
		 header("HTTP/1.0 404 Not Found");
		 exit;
	}
}

function get_request(){
	return $_REQUEST;
}