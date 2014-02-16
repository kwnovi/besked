<?php

require_once(__APP_DIR__.'view.php');

function home_view(){
	if(session_status() == PHP_SESSION_ACTIVE)
		echo 'home';
	else
		(new View(__TEMPLATES_DIR__.'landing.php', array(
			'login_data' => false,
			'signup_data' => false,
			)
		))->render();
}
