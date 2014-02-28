<?php
//includes
define("_SL_", ((PHP_OS != "WINNT")?'/':'\\'));
define("__APP_DIR__", dirname(__FILE__)._SL_.'app'._SL_);
define("__TEMPLATES_DIR__", __APP_DIR__.'templates'._SL_);

// urls
define("__ROOT__", '/besked/');
define("__WWW_DIR__", __ROOT__.'www/');

require_once (__APP_DIR__.'router.php');

Router::get_instance()->get_route(array(
	"#^/$#" => "home_view",
	"#^/besked/$#" => "home_view", // dev
	"#users/[a-zA-Z0-9/?=]#" => "user_routes_handler",
	"#user/[a-zA-Z0-9/?=]#" => "user_routes_handler",
	"#messages/[a-zA-Z0-9/?=]#" => "messages_routes_handler",
	"#discussions/[a-zA-Z0-9/?=]#" => "discussions_route_handler",
	));

 

/* TEST ADD
$user = User::create_user();
$user->set_attr('nickname', 'jaime');
$user->set_attr('password', 'le');
$user->set_attr('email', 'jam@bon.fr');
$user->set_attr('created_datetime', '2014-05-01');

$user->save();
var_dump($user);

$n_user = User::get_by_id(8);

var_dump($n_user);
*/
