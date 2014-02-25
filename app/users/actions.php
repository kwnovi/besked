<?php

require_once(__APP_DIR__.'view.php');
require_once(__APP_DIR__.'validator.php');
require_once(__APP_DIR__.'users'._SL_.'model.php');


function login(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_POST['password'] = crypt($_POST['password'], 'toto');
		$user = User::get_from_request($_POST);
		if(!$user){
			$view = new View(__TEMPLATES_DIR__.'landing.php', array(
				'signup_data' => false,
				'login_data' => 'Cette adresse et ce mot de passe ne correspondent pas. Veuillez recommencer.'
			));
		} else {
			session_start();
			$_SESSION['userID'] = $user->get_id();
			$view = new View(__TEMPLATES_DIR__.'home.php', array('user' => $user));
		}
		$view->render();
	} else {
		header('Location: '.__ROOT_DIR__, true, 301);
	}
}

function signup(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$validator = new Validator();
		$result = $validator->validate(User::validation_fields(), $_POST);
		if($result['has_errors']){
			$view = new View(__TEMPLATES_DIR__.'landing.php', array(
				'login_data' => false,
				'signup_data' => $result)
			);
		} else {
			//SQL UNIQUE
			if(User::check_nickname($_POST['nickname'])){
				$_POST['password'] = crypt($_POST['password'], 'toto');
				$_POST['created_datetime'] = date("Y-m-d H:i:s");
				$user = User::create_from_request($_POST);
				$user->save();
				session_start();
				$_SESSION['userID'] = $user->get_id();
				$view = new View(__TEMPLATES_DIR__.'home.php',array('user' => $user));
			} else {
				$result['nickname'] = array(
					"error" => true,
					"message" => "Pseudonyme déjà pris."
				);
				$view = new View(__TEMPLATES_DIR__.'landing.php', array(
					'login_data' => false,
					'signup_data' => $result
				));
			}
		}
		$view->render();
	} else {
		header('Location: '.__ROOT_DIR__, true, 301);		
	}
}

function get_all_users (){
	$status_code = 200;
	header('HTTP/1.0 '.$status_code);
    header('Content-Type: application/json');
    echo json_encode(User::find_all());
}

function get_contacts(){
	$user = User::get_by_id($_SESSION['userID']);
	$contacts = $user->get_contacts();
	$data = array();
	for ($i=0; $i < count($contacts); $i++) { 
		$data[$i] = $contacts[$i]->get_fields_values();
	}
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($data);
}