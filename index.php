<?php

/**
 * INDEX
 *
 * Point d'entrée de l'application, la configuration apache
 * redirige l'ensemble des requètes (non statiques) vers ce
 * fichier. C'est la classe Router qui prend en charge par 
 * suite la gestion des url et des actions associèes.
 *
 * Licensed under The WTFPL License
 *
 * @license http://www.wtfpl.net/txt/copying/
 * @author Lucien Varacca <k.wnovi@gmail.com>
 * @author Quentin Le Bour <q.lebour@gmail.com>
 */

// Constantes includes
define("_SL_", ((PHP_OS != "WINNT")?'/':'\\'));
define("__APP_DIR__", dirname(__FILE__)._SL_.'app'._SL_);
define("__TEMPLATES_DIR__", __APP_DIR__.'templates'._SL_);

// Constante urls
define("__ROOT__", '/besked/');
define("__WWW_DIR__", __ROOT__.'www/');

require_once (__APP_DIR__.'router.php');

Router::get_instance()->get_route(array(
	"#^/$#" => "home_view",
	"#^/besked/$#" => "home_view", // dev
	"#^/besked/users/[a-zA-Z0-9/?=]#" => "user_routes_handler",
	"#^/besked/user/[a-zA-Z0-9/?=]#" => "user_routes_handler",
	"#^/besked/messages/[a-zA-Z0-9/?=]#" => "messages_routes_handler",
	"#^/besked/discussions/[a-zA-Z0-9/?=]#" => "discussions_routes_handler",
	));