<?php

class Validator{
	const EMAIL_REGEX = "#^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$#";
	const PASSWORD_LENGTH = 6;

	public static function validate($validation_fields, $request_data){
		$return_status = array('has_errors' => false);
		foreach ($validation_fields as $key => $rule) {
			if(array_key_exists($key, $request_data)){
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