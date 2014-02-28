<?php
require_once(__APP_DIR__.'discussions'._SL_.'model.php');
require_once(__APP_DIR__.'users'._SL_.'model.php');

function get_user_all_discussion (){

$user = User::get_by_id($_SESSION['userID']);
$discussions = $user -> get_user_all_discussion();

	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($discussions);


}