<?php

require_once(__APP_DIR__.'view.php');

function home_view(){
	session_start();
	if(isset($_SESSION['userID'])){
		$view = new View(__TEMPLATES_DIR__.'home.php', array('user' => User::get_by_id($_SESSION['userID'])));
	} else {
		$view = new View(__TEMPLATES_DIR__.'landing.php', array(
			'login_data' => false,
			'signup_data' => false
			)
		);
	}
	$view->render();
}
