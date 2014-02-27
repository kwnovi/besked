<?php

function user_routes_handler(){
	Router::get_instance()->get_route(array(
		'#/users/signup#' => 'signup',
		'#/users/login#' => 'login',
		'#/users/logout#' => 'logout',
		'#/users/find/all#' => 'A;get_all_users',
		'#/user/contacts#' => 'A;get_contacts'
		));
}

