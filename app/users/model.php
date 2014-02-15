<?php
require_once(__APP_DIR__.'model.php');

class User extends Model{
	const table_name = "user";
	const fields_names = "id,email,password,nickname,created_datetime";

	
	public static function create_user(){
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
	
	
	public static function get_by_id($id){
		$instance = new self();
		return $instance->find($id);
	}

/*
	public static function __construct_fill_fields($fields_values){
		$instance = new self();
		$instance->fill_fields($fields_values);
		return $instance;
	}
*/
	
}