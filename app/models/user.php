<?php
require(dirname(__FILE__)."/model.php");

class User extends Model{
	const table_name = "USER";

	public function __construct(){
		//parent::__construct();
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

	public static function __construct_by_id($id){
		$instance = new self();
		
		return $instance;
	}

	public function __construct_fill_fields($fields_values){
		parent::__construct_fill_fields($fields_values);
	}

	public function get_fields(){ return array_keys($this->fields);}
}
?>