<?php

require_once(__APP_DIR__.'view.php');
require_once(__APP_DIR__.'validator.php');
require_once(__APP_DIR__.'users'._SL_.'model.php');
require_once(__APP_DIR__."database.php");

function register_connection($id, $is_new=false){
	$db = Database::getConnection();
	if($is_new){
		$stmt = $db->prepare("INSERT INTO users_status(user_id, session_id, status)
							  VALUES (:uid,:sid,'1')");
	} else {
		$stmt = $db->prepare("UPDATE  users_status 
							  SET  session_id =  :sid, status =  '1' 
							  WHERE  user_id = :uid");
	}
	$stmt->bindValue(':uid', $id, PDO::PARAM_INT);
	$stmt->bindValue(':sid', session_id(), PDO::PARAM_STR);
	$stmt->execute() or die(print_r($stmt->errorInfo(), TRUE));
}

function unregister_connection($id){
	$db = Database::getConnection();
	$stmt = $db->prepare("UPDATE  users_status 
						  SET  session_id =  null, status =  '0' 
						  WHERE  user_id = :uid");
	$stmt->bindValue(':uid', $id,PDO::PARAM_INT);
	$stmt->execute() or die(print_r($stmt->errorInfo(), TRUE));
}

function get_connected(){
	$db = Database::getConnection();
	$stmt = $db->prepare("SELECT  user_id
						  FROM users_status 
						  WHERE  status = '1'");
	$stmt->execute() or die(print_r($stmt->errorInfo(), TRUE));
	$result = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($result, $row['user_id']);
	}
	return $result;
}

function login(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_POST['password'] = crypt($_POST['password'], 'toto');
		$user = User::get_from_request($_POST);
		if(!$user){
			$view = new LandingView(__TEMPLATES_DIR__.'landing.php', array(
				'signup_data' => false,
				'login_data' => 'Cette adresse et ce mot de passe ne correspondent pas. Veuillez recommencer.'
			));
		} else {
			session_start();
			$_SESSION['userID'] = $user->get_id();
			register_connection($user->get_id());
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
			$view = new LandingView(__TEMPLATES_DIR__.'landing.php', array(
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
				// pour récupérer l'id
				$user = $user->find_by_email($user->get_attr("email"));
				session_start();
				$_SESSION['userID'] = $user->get_id();
				register_connection($user->get_id(), true);
				$view = new HomeView(__TEMPLATES_DIR__.'home.php',array('user' => $user));
			} else {
				$result['nickname'] = array(
					"error" => true,
					"message" => "Pseudonyme déjà pris."
				);
				$view = new HomeView(__TEMPLATES_DIR__.'landing.php', array(
					'login_data' => false,
					'signup_data' => $result
				));
			}
		}
		$view->render();
	} else {
		header('Location: '.__ROOT__, true, 301);		
	}
}

function logout(){
	session_start();
	unregister_connection($_SESSION['userID']);
	session_destroy();
	header('Location: '.__ROOT__, true, 301);
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
	$connected = get_connected();
	$data = array();
	for ($i=0; $i < count($contacts); $i++) { 
		$data[$i] = $contacts[$i]->get_fields_values();
		$data[$i]["connected"] = in_array($contacts[$i]->get_id(), $connected);
	}
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode($data);
}

function find_by_nickname(){
	$search_term = explode("/",$_SERVER['REQUEST_URI'])[4];//dernier param
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode(User::find_by_nickname($search_term));
}

function add_contact(){
	$id = end(explode("/",$_SERVER['REQUEST_URI']));
	$user = User::get_by_id($_SESSION['userID']);
	
	header('HTTP/1.0 200');
    header('Content-Type: application/json');
    echo json_encode(array('response'=>$user->add_contact($id)));
}