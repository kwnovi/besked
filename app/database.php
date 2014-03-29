<?php
/**
 * DATABASE
 *
 * Singleton permettant la connexion à la base
 *
 * Licensed under The WTFPL License
 *
 * @license http://www.wtfpl.net/txt/copying/
 * @author Lucien Varacca <k.wnovi@gmail.com>
 * @author Quentin Le Bour <q.lebour@gmail.com>
 */

class Database{
	private static $link = null ;

	public static function getConnection ( ) {
	    if (self :: $link) {
	        return self :: $link;
	    }

	    $dsn = "mysql:dbname=besked;host=localhost";
	    $user = "root";
	    $password = "";

	    try {
		    self :: $link = new PDO($dsn, $user, $password);
	    } catch (Exception $e) {
	    	// dev
	    	die($e->getMessage());	
	    }
	    return self :: $link;
	}
}


?>