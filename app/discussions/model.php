<?php
require_once(__APP_DIR__.'model.php');

class Discussion extends Model{
	const table_name = "discussion";
	const fields_names = "id,created_datetime,title";
	
	public static function create(){
		$instance = new self();
		$instance->new_instance = true;
		$instance->fields = array(
			'id' => array(
				'value' => null,
				'updated' => false
			),
			'created_datetime'=> array(
				'value' => null,
				'updated' => false
			),
			'title'=> array(
				'value' => null,
				'updated' => false
			)	
		);
		return $instance;
	}
}