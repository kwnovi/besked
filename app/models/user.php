<?php
require(dirname(__FILE__)."/model.php");

class User extends Model{
	const table_name = "USER";
	const fields_names = "id,email,password,nickname,created_datetime";

/*	
	 public function __construct(){
		$this->fields = array(
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
	}
	*/
	
	public static function __construct_by_id($id){
		$instance = new self();
		return $instance->find($id);
	}

	public static function __construct_fill_fields($fields_values){
		parent::__construct_fill_fields($fields_values);
	}

	
}