<?php

require_once(__APP_DIR__.'view.php');

function home_view(){
	if(isset($_SESSION['user']))
		echo 'home';
	else
		(new View(__TEMPLATES_DIR__.'landing.php', array('data' => false)))->render();
}
