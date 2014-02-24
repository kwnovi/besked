<?php
require_once(__APP_DIR__.'model.php');

class Message extends Model{
	const table_name = "message";
	const fields_names = "id,content,created_datetime,discussion_id,user_id";
	
	public static function create(){
		$instance = new self();
		$instance->new_instance = true;
		$instance->fields = array(
			'id' => array(
				'value' => null,
				'updated' => false
			),
			'content'=> array(
				'value' => null,
				'updated' => false
			),
			'created_datetime'=> array(
				'value' => null,
				'updated' => false
			),
			'discussion_id'=> array(
				'value' => null,
				'updated' => false
			),
			'user_id'=> array(
				'value' => null,
				'updated' => false
			),
			
		);
		return $instance;
	}
}