<?php

require_once (dirname(__FILE__).'\app\router.php');
	
Router::get_instance()->get_route(array(
	"#^/$#" => "home_view",
	"#^/besked$#" => "home_view", // dev
	"#users/[a-zA-Z0-9/?=]#" => "user_routes_handler",
	"#messages/[a-zA-Z0-9/?=]#" => "messages_routes_handler",
	"#discussions/[a-zA-Z0-9/?=]#" => "discussions_route_handler",
	), $_SERVER['REQUEST_URI']);


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
