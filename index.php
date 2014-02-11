<?php
use Router\Router_Utilities;
use User\Route;


var_dump($_REQUEST);

$url = $_SERVER['REQUEST_URI'];
$request = Router_Utilities\get_request();

$routes = array(
	"#^users/[a-zA-Z0-9/?=]#" => "User\Route",
	"#^messages/[a-zA-Z0-9/?=]#" => "Messages\Route",
	"#^discussions/[a-zA-Z0-9/?=]#" => "Discussions\Route",
	);

foreach ($routes as $pattern => $router) {
	if(preg_match($pattern, $url)){
		call_user_func($router.'\handle', $request);
		exit;
	}
}


/*
$mapping = array(
	'/login' => )
*/

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
