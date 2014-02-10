<?php
require(dirname(__FILE__)."/app/models/user.php");

$user = User::__construct_by_id(1);
var_dump($user);
