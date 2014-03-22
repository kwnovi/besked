<?php
require_once(__APP_DIR__.'model.php');
//require_once(__APP_DIR__.'users'._SL_.'model.php');

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

	public static function get_participants_id($id=null){
		$stmt = self::query("SELECT user_id
							FROM user_discussion
							WHERE discussion_id =:id", 
							array(
								'id'=> (is_null($id))?$this->get_id():$id,
							)
						);
		$_result = self::execute($stmt);
		if(count($_result) == 1){
			return $_result[0]['user_id'];
		} else {
			$result = array();
			foreach ($_result as $key => $value){
				array_push($result, $value['user_id']);
			}
			return $result;
		}
	}

	public static function get_user_all_discussions($user_id){
		$stmt = self::query("SELECT ".self::fields_names." 
							 FROM USER_DISCUSSION 
							 JOIN DISCUSSION ON USER_DISCUSSION.discussion_id = DISCUSSION.id 
							 WHERE USER_DISCUSSION.user_id = :id", 
							array(
								'id'=> $user_id,
							)
						);
		$result = self::execute($stmt);
		foreach ($result as $key => $value) {
			$result[$key]["participants"] = static::get_participants_id($value['id']);
		}
		return $result;
	}


	public static function get_latest_messages_all_discussions($user_id){
		$stmt = self::query("
			SELECT 
				   message.id,
				   message.content,
				   message.created,
				   message.discussion_id,
				   message.user_id
			FROM USER_DISCUSSION 
			JOIN discussion_message on discussion_message.discussion_id = USER_DISCUSSION.discussion_id
			JOIN message on message.id = discussion_message.message_id
			WHERE USER_DISCUSSION.user_id = :id and message.id in (
				select m1.id from message as m1
				left outer join message as m2 on m1.discussion_id = m2.discussion_id
					and m2.created > m1.created
				where m2.created is null)",
			array(
				'id'=> $user_id,
			)
		);
		$result = self::execute($stmt);
		return $result;
	}
}