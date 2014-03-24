<?php

function discussions_routes_handler(){
	Router::get_instance()->get_route(array(
		'#/discussions/user/all#' => 'A;get_user_all_discussions',
		'#/discussions/new#' => 'A;create_new_discussion',
		'#/discussions/participants/#' => 'A;get_participants',
		'#/discussions/messages/#' => 'A;get_messages',
		'#/discussions/add-msg#' => 'A;add_message'
		));
}

