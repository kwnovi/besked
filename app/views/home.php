<?php

function home_view(){
	if(isset($_SESSION['user']))
		echo 'home';
	else
		echo 'landing';
}
