<?php
require_once(__APP_DIR__.'discussions'._SL_.'model.php');
//require_once(__APP_DIR__.'users'._SL_.'model.php');

function get_user_all_discussions (){
	$discussions = Discussion::get_user_all_discussions($_SESSION['userID']);
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($discussions);
}

function create_new_discussion() {
	
var_dump($_POST);


	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode(array("message" => "La discussion a été crée"));


}