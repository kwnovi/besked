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
			WHERE USER_DISCUSSION.user_id = :id1 and message.user_id <> :id2 and message.id in (
				select m1.id from message as m1
				left outer join message as m2 on m1.discussion_id = m2.discussion_id
					and m2.created > m1.created
				where m2.created is null)",
			array(
				'id1'=> $user_id,
				'id2'=> $user_id
			)
		);
		$result = self::execute($stmt);
		return $result;
	}

	public static function get_participants($id){
		$stmt = self::query("SELECT ".User::get_fields_names()."
							FROM user_discussion
							JOIN user on user.id = user_discussion.user_id
							WHERE discussion_id = :did AND user.id <> :uid", 
							array(
								'did'=> $id,
								'uid'=> $_SESSION['userID']
							)
						);
		$result = self::execute($stmt);
		return $result;
	}

	public static function get_messages($id){
		$stmt = self::query("SELECT *
							FROM message
							WHERE discussion_id =:id", 
							array(
								'id'=> $id,
							)
						);
		$result = self::execute($stmt);
		return $result;
	}


	// coding horror monster show
	public static function create_from_request(){
		$db = Database::getConnection();
		$stmt = self::query("INSERT INTO `discussion`(`title`) VALUES (:title)", 
							array('title'=> $_POST['title'])
							);
		self::execute($stmt);
		$discussion_id = $db->lastInsertId();
		$stmt = self::query("INSERT INTO `user_discussion`(user_id, discussion_id) VALUES (:uid, :did)", 
							array('uid'=> $_SESSION['userID'], 'did'=> $discussion_id)
							);
		self::execute($stmt);
		foreach ($_POST['recipients'] as $key => $value) {
			$stmt = self::query("INSERT INTO `user_discussion`(user_id, discussion_id) VALUES (:uid, :did)", 
							array('uid'=> $value, 'did'=> $discussion_id)
							);
			self::execute($stmt);
		}
		$stmt = self::query("INSERT INTO `message`(`content`,`discussion_id`, `user_id`) VALUES (:content, :did, :uid)", 
							array('uid'=> $_SESSION['userID'], 'did'=> $discussion_id, 'content'=> $_POST['message'])
							);
		self::execute($stmt);
		$message_id = $db->lastInsertId();
		$stmt = self::query("INSERT INTO `discussion_message`(message_id, discussion_id) VALUES (:mid, :did)", 
						array('mid'=> $message_id, 'did'=> $discussion_id)
						);
		self::execute($stmt);
		return $discussion_id;
	}

	// again
	public static function add_message(){
		$db = Database::getConnection();
		$stmt = self::query("INSERT INTO `message`(`content`,`discussion_id`, `user_id`) VALUES (:content, :did, :uid)", 
							array('uid'=> $_SESSION['userID'], 'did'=> $_POST['discussion_id'], 'content'=> $_POST['message'])
							);
		self::execute($stmt);
		$message_id = $db->lastInsertId();
		$stmt = self::query("INSERT INTO `discussion_message`(message_id, discussion_id) VALUES (:mid, :did)", 
						array('mid'=> $message_id, 'did'=> $_POST['discussion_id'])
						);
		self::execute($stmt);
		return $message_id;
	}

}