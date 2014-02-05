<?php
require(dirname(__FILE__)."/app/models/user.php");

$user = new User();
var_dump($user->find(1));
?>