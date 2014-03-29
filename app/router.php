<?php

/**
 * ROUTER
 *
 * Singleton permet de mapper les url sur des fonctions
 * 
 * Fonctionnement simplissime :
 * 
 * Router::get_instance()->get_route(array(
 *		'#url1/bla/bla#' => 'action_publique',
 *		'#jaime/les/petits/suisses#' => 'A;action_privee'
 *		));
 * 
 * On récupère une instance de Router et on appelle get_route en lui passant un array.
 * Cet array doit avoir en clefs des regex valides d'url et en valeur 
 * le nom des fonctions que l'on désire mapper.
 * Préfixer le nom de la méthode par "A;" pour vérifier si l'utilisateur est bien connecté.
 *
 * 
 * Licensed under The WTFPL License
 *
 * @license http://www.wtfpl.net/txt/copying/
 * @author Lucien Varacca <k.wnovi@gmail.com>
 * @author Quentin Le Bour <q.lebour@gmail.com>
 */


// TODO 
// autoloader les fichiers action.php 
// ou trouver quelque chose de plus malin que de tout charger comme des brutes
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
					// moche
					$handler_sanitized[0] = $handler_sanitized[1];
				}
				// execution de l'action
				call_user_func($handler_sanitized[0]);
				exit;
			}
		}
		self::not_found(); // si l'url est inconnue au bataillon 
	}

	private static function not_found(){
		header("HTTP/1.0 404 Not Found", false, 404);
		$view = new NotFoundView(__TEMPLATES_DIR__.'404.php');
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

