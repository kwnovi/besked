<?php

require_once(__APP_DIR__.'view.php');

function login(){
	//if($_REQUEST['method'] == 'POST'){
		$view = new View(__TEMPLATE_DIR__.'login.php', array('test' => 'toto'));
		$view->render();
	//}
}

function signup(){
	echo 'signup';
}