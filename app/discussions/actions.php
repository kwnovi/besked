<?php
require_once(__APP_DIR__.'discussions'._SL_.'model.php');
//require_once(__APP_DIR__.'users'._SL_.'model.php');

function get_user_all_discussions (){
	$discussions = Discussion::get_user_all_discussions($_SESSION['userID']);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($discussions);
}

function get_messages(){
	$discussion_id = end(explode("/",$_SERVER['REQUEST_URI']));
	$messages = Discussion::get_messages($discussion_id);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($messages);
}

function get_participants(){
	$discussion_id = end(explode("/",$_SERVER['REQUEST_URI']));
	$participants = Discussion::get_participants($discussion_id);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($participants);
}

// TODO
function create_new_discussion() {
    echo json_encode(array("message" => "La discussion a été crée"));
}