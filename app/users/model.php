<?php
require_once(__APP_DIR__.'model.php');

class User extends Model{
	const table_name = "user";
	const fields_names = "id,email,password,nickname,created_datetime";

	public static function validation_fields(){
		return array(
			"email" => "email",
			"password" => "password",
			"nickname" => "mandatory"
			);
	}
	
	public static function create(){
		$instance = new self();
		$instance->new_instance = true;
		$instance->fields = array(
			'id' => array(
				'value' => null,
				'updated' => false
			),
			'email'=> array(
				'value' => null,
				'updated' => false
			),
			'password'=> array(
				'value' => null,
				'updated' => false
			),
			'nickname'=> array(
				'value' => null,
				'updated' => false
			),
			'created_datetime'=> array(
				'value' => null,
				'updated' => false
			),
		);
		return $instance;
	}
	
	public static function create_from_request($request){
		$instance = self::create();
		foreach ($request as $key => $value) {
			$instance->fields[$key]['value'] = $value;
		}
		return $instance;
	}
	
	public static function get_by_id($id){
		$instance = new self();
		return $instance->find($id);
	}

	public static function get_from_request($request){
		$stmt = self::query("SELECT ".self::fields_names." FROM ".self::table_name." WHERE email = :email AND password = :password", 
							array(
								"email" => $request['email'],
								"password" => $request['password']
								));
		$results = self::execute($stmt);
		return (empty($results))?false:self::__construct_fill_fields($results[0]);
	}

	public static function check_nickname($nick){
		$stmt = self::query("SELECT id FROM ".self::table_name." WHERE nickname = :n", array('n'=>$nick));
		$results = self::execute($stmt);
		return empty($results);
	}

/*
	public static function __construct_fill_fields($fields_values){
		$instance = new self();
		$instance->fill_fields($fields_values);
		return $instance;
	}
*/
	
}