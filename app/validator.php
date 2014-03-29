<?php

/**
 * VALIDATOR
 *
 * Classe utilitaire permettant d'automatiser la
 * validation de données. 
 *
 * TODO 
 * Utiliser un pattern singleton ou mieux lier 
 * avec la classe model.
 *
 * Licensed under The WTFPL License
 *
 * @license http://www.wtfpl.net/txt/copying/
 * @author Lucien Varacca <k.wnovi@gmail.com>
 * @author Quentin Le Bour <q.lebour@gmail.com>
 */


// règles supportées : 
// email
// password
// mandatory (par default si champ mentionné)

class Validator{
	// patterns standard
	const EMAIL_REGEX = "#^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$#";
	const PASSWORD_LENGTH = 6;

	// validation_fields tableau assoc avec le nom du champ en clef
	// et le type de règles en valeur.
	public static function validate($validation_fields, $request_data){
		$return_status = array('has_errors' => false);
		foreach ($validation_fields as $key => $rule) {
			if(array_key_exists($key, $request_data)){
				// moche
				switch ($rule) {
					case 'email':
						if (preg_match(self::EMAIL_REGEX, $request_data[$key])) {
							$return_status[$key] = array('error' => false);
						} else {
							$return_status['has_errors'] = true;
							$return_status[$key] = array(
								'error' => true,
								'message' => 'Mauvais format'
								);
						}
						break;
					case 'password':
						if(strlen($request_data[$key]) < self::PASSWORD_LENGTH){
							$return_status['has_errors'] = true;
							$return_status[$key] = array(
								'error' => true,
								'message' => self::PASSWORD_LENGTH.' caractères minimum.'
								);
						} else {
							$return_status[$key] = array("error" => false);
						}
						break;
					default:
						if($request_data[$key] == null){
							$return_status['has_errors'] = true;
							$return_status[$key] = array(
								'error' => true,
								'message' => 'Vide.'
								);
						} else {
							$return_status[$key] = array('error' => true);
						}
						break;
				}
			} else {
				$return_status['has_errors'] = true;
				$return_status[$key] = array(
								'error' => true,
								'message' => $key.' est obligatoire.'
								);
			}
		}
		return $return_status;
	}
}