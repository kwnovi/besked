<?php

function user_routes_handler(){
	Router::get_instance()->get_route(array(
		'#/users/signup#' => 'signup',
		'#/users/login#' => 'login',
		'#/users/find/all#' => 'get_all_users'
		));
}

