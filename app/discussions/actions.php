<?php
require_once(__APP_DIR__.'discussions'._SL_.'model.php');
//require_once(__APP_DIR__.'users'._SL_.'model.php');

function get_user_all_discussions (){
	$discussions = Discussion::get_user_all_discussions($_SESSION['userID']);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo my_json_encode($discussions);
}

function get_messages(){
	$splitted_url = explode("/",$_SERVER['REQUEST_URI']);
	$discussion_id = end($splitted_url);
	$messages = Discussion::get_messages($discussion_id);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo my_json_encode($messages);
}

function get_participants(){
	$splitted_url = explode("/",$_SERVER['REQUEST_URI']);
	$discussion_id = end($splitted_url);
	$participants = Discussion::get_participants($discussion_id);
/*	header('HTTP/1.0 200');
    header('Content-Type: application/json');*/
    echo my_json_encode($participants);
}

// TODO
function create_new_discussion() {
    echo my_json_encode(array("message" => "La discussion a été crée"));
}

// QUICKFIX
//pb avec le json_encode => vide les chaînes pas encodés en utf-8
//toujours utiliser cette fonction avant d'envoyer un json au client
// TODO
// Passer la base en utf-8 (normalement déjà le cas)
/*function my_json_encode($arr){
	array_walk_recursive($arr, function (&$item, $key) { 
		if (is_string($item)) 
			$item = utf8_encode($item); 
	});
	return json_encode($arr);
}*/