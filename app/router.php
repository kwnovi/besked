<?php
require_once(__APP_DIR__.'users'._SL_.'route.php');
require_once(__APP_DIR__.'users'._SL_.'actions.php');
require_once(__APP_DIR__.'discussions'._SL_.'route.php');
require_once(__APP_DIR__.'discussions'._SL_.'actions.php');

require_once(__APP_DIR__.'views'._SL_.'home.php');
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
				$handler_sanitized = explode(';',$handler);
				if($handler_sanitized[0] == "A"){
					self::check_authentification();
					$handler_sanitized[0] = $handler_sanitized[1];
				}
				call_user_func($handler_sanitized[0]);
				exit;
			}
		}
		self::not_found();
	}

	private static function not_found(){
		header("HTTP/1.0 404 Not Found", false, 404);
		$view = new View(__TEMPLATES_DIR__.'404.php');
		$view->render();
		exit;
	}

	private static function check_authentification(){
		session_start();
		if(!isset($_SESSION['userID'])){
			session_write_close();
			header("Location: /",true,401);
			exit;
		}
	}

}

