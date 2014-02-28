<?php
require_once(__APP_DIR__.'model.php');
require_once(__APP_DIR__.'users'._SL_.'model.php');

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



	public static function get_user_all_discussion(){
		$stmt = self::query("SELECT title, id FROM USER_DISCUSSION JOIN DISCUSSION ON USER_DISCUSSION.discussion_id = DISCUSSION.id WHERE USER_DISCUSSION.user_id = :id", 
			array(
				'id'=>$this->get_id(),
			)
			);
		$result = self::execute($stmt);
		return $result;

	}

}