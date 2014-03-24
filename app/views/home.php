<?php

require_once(__APP_DIR__.'view.php');
require_once(__APP_DIR__.'discussions'._SL_.'model.php');

function home_view(){
	session_start();
	if(isset($_SESSION['userID'])){
		$user = User::get_by_id($_SESSION['userID']);
		$user_contacts = $user->get_contacts();
		$connected = get_connected();
		$contacts = array();
		for ($i=0; $i < count($user_contacts); $i++) { 
			$contacts[$i] = $user_contacts[$i]->get_fields_values();
			$contacts[$i]["connected"] = in_array($user_contacts[$i]->get_id(), $connected);
		}
		$view = new HomeView(__TEMPLATES_DIR__.'home.php', array(
			'user_j' => $user->toJson(),
			'user' => $user,
			'contacts' => my_json_encode($contacts),
			'discussions' => my_json_encode(Discussion::get_user_all_discussions($user->get_id())),
			'messages' => my_json_encode(Discussion::get_latest_messages_all_discussions($user->get_id()))
			));
	} else {
		$view = new LandingView(__TEMPLATES_DIR__.'landing.php', array(
			'login_data' => false,
			'signup_data' => false
			)
		);
	}
	$view->render();
}

// QUICKFIX
//pb avec le json_encode => vide les chaînes pas encodés en utf-8
//toujours utiliser cette fonction avant d'envoyer un json au client
// TODO
// Passer la base en utf-8 (normalement déjà le cas)
function my_json_encode($arr){
	array_walk_recursive($arr, function (&$item, $key) { 
		if (is_string($item)) 
			$item = htmlentities($item); 
	});
	return json_encode($arr);
}