<?php
require(dirname(__FILE__)."/app/models/user.php");

$user = User::create_user();
$user->set_attr('nickname', 'jaime');
$user->set_attr('password', 'le');
$user->set_attr('email', 'jam@bon.fr');
$user->set_attr('created_datetime', '2014-05-01');

$user->save();
var_dump($user);

$n_user = User::get_by_id(8);

var_dump($n_user);

