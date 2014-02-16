<?php

require_once(__APP_DIR__.'view.php');
require_once(__APP_DIR__.'validator.php');
require_once(__APP_DIR__.'users'._SL_.'model.php');


function login(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$view = new View(__TEMPLATES_DIR__.'login.php', array('test' => 'toto'));
		$view->render();
	}
	header('Location: '.__ROOT_DIR__, true, 301);
}

function signup(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$validator = new Validator();
		$result = $validator->validate(User::validation_fields(), $_POST);
		if($result['has_errors']){
			$view = new View(__TEMPLATES_DIR__.'landing.php', array('data' => $result));
		} else {
			if(User::check_nickname($_POST['nickname'])){
				$_POST['password'] = crypt($_POST['password'], 'toto');
				$_POST['created_datetime'] = date("Y-m-d H:i:s");
				$user = User::create_from_request($_POST);
				$user->save();
				session_start();
				$view = new View(__TEMPLATES_DIR__.'home.php',array('user' => $user));
			} else {
				$result['nickname'] = array(
					"error" => true,
					"message" => "Pseudonyme déjà pris."
				);
				$view = new View(__TEMPLATES_DIR__.'landing.php', array('data' => $result));
			}
		}
		$view->render();
	} else {
		header('Location: '.__ROOT_DIR__, true, 301);		
	}
}