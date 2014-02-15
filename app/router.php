<?php
require_once(__APP_DIR__.'users\route.php');
require_once(__APP_DIR__.'users\actions.php');
require_once(__APP_DIR__.'views\home.php');
require_once(__APP_DIR__.'view.php');

// singleton
class Router{
	
	private static $instance;
	
	protected function __construct(){}

	public static function get_instance(){
		if(!isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	public static function get_route($routes){
		foreach ($routes as $pattern => $handler) {
			if(preg_match($pattern, $_SERVER['REQUEST_URI'])){
				call_user_func($handler);
				exit;
			}
		}
		self::not_found();
	}

	private static function not_found(){
		header("HTTP/1.0 404 Not Found", false, 404);
		$view = new View(__TEMPLATE_DIR__.'404.php');
		$view->render();
		 exit;
	}
}

