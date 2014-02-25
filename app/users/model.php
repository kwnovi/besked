<?php
require_once(__APP_DIR__.'model.php');

class User extends Model{
	const table_name = "user";
	const fields_names = "id,email,password,nickname,created_datetime,picture_path";

	public static function get_fields_names(){
		return preg_replace("/,password/", "", self::fields_names);
	}

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
			'picture_path'=> array(
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

	//not useless
	public static function users_from_array($array){
		$tab_utilisateur = array();
		for ($i=0; $i < count($array) ; $i++) { 
			$tab_utilisateur[$i]=self::__construct_fill_fields($array[$i]);
		}
		return $tab_utilisateur;
	}

	public function get_contacts(){
		$stmt = self::query("SELECT ".self::get_fields_names()." FROM ".self::table_name."
							 WHERE id IN (
								SELECT C1.user_id_2 FROM ".self::table_name." as U1
								JOIN contact as C1 on U1.id = C1.user_id_1 WHERE U1.id = :id1
								UNION
								SELECT C2.user_id_1 FROM ".self::table_name." as U2
								JOIN contact as C2 on U2.id = C2.user_id_2 WHERE U2.id = :id2)", 
							array(
								'id1'=>$this->get_id(),
								'id2'=>$this->get_id(),
								)
							);
		$results = self::execute($stmt);
		return self::users_from_array($results);
	}
/*
	public static function __construct_fill_fields($fields_values){
		$instance = new self();
		$instance->fill_fields($fields_values);
		return $instance;
	}
*/
	
}