<?php
require("database.php");

abstract class Model{

	protected $fields;

	protected $new_instance = false;

	protected static function __construct_fill_fields($fields_values){
		$instance = new static();
		$instance->fill_fields($fields_values);
		return $instance;
	}
	
	// on retourne un nouvel objet ou on le charge dans l'instance courante ?
	public function find($id){
		//$fields = implode(',', $this->get_fields_names());
		$fields = $this::fields_names;
		$table = $this::table_name;

		$stmt = $this->query("SELECT $fields FROM $table WHERE id = :id LIMIT 1", array('id' => $id));

		/* Pour passer le test unitaire
		$data = $this->execute($stmt);
		foreach ($data as $key => $value) {
			return static::__construct_fill_fields($value);
		}
		*/
		return static::__construct_fill_fields($this->execute($stmt)[0]);
	}

	public function save(){
		// si c'est une nouvelle instance (pas deja presente en base)
		// on l'ajoute au lieu de sauvegarder
		if($this->new_instance) return $this->add();
		$table = $this::table_name;
		$query_string = "UPDATE $table SET ";
		$params = array();
		foreach ( $this->fields as $key => $value) {
			//moche
			if($key != 'id'){
				$params[$key] = $value['value'];
				$query_string .= sprintf('`%s` = %s,', $key, ':'.$key);
			}
			else{
				$params[$key] = (int) $value['value'];
			}
		}
		$query_string = rtrim($query_string,',');
		$stmt = $this::query($query_string.' WHERE id = :id', $params);
		$this::execute($stmt);
	}

	private function add(){
		$table = $this::table_name;
		$fields_names = $this::fields_names;
		$query_string = "INSERT INTO $table ($fields_names) VALUES (";
		$params = array();
		foreach ( $this->fields as $key => $value) {
			if($key != 'id' && $value['value'] != NULL){
				$query_string .= '?,';
				array_push($params, $value['value']);
			} else {
				$query_string .= 'NULL,';
			}
		}
		$query_string = rtrim($query_string,',');
		$stmt = $this::query($query_string.')');
		$this::execute($stmt, $params);
	}

	protected static function query($query_string, $params=NULL){
		$db = Database::getConnection();
		$stmt = $db->prepare($query_string);
		// si c'est une requete avec des '?'
		if($params == NULL) return $stmt;
		
		foreach ($params as $key => $val) {
			$stmt->bindValue(":$key", $val);
			if(!$stmt) print_r($stmt->errorInfo(), TRUE);
		}
		return $stmt;
	}

	protected static function execute($stmt, $params=NULL){
		try {
			if($params == NULL){
				$stmt->execute() or die(print_r($stmt->errorInfo(), TRUE));
			} else {
				$stmt->execute($params) or die(print_r($stmt->errorInfo(), TRUE));
			} 
			// $stmt == false si problème dans la query ou pas de lignes renvoyees
			if (!$stmt) {
				print_r($stmt->errorInfo(), TRUE);
				throw new Exception("Not found", 1);
			}
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public static function get_by_id($id){
		$instance = new static();
		return $instance->find($id);
	}

	private function get_updated_fields(){
		$updated_fields = array();
		foreach ($this->fields as $key => $value) {
			if ($this->fields[$key]['updated']) {
				$updated_fields->array_push($updated_fields, $key);
			}
		}
		return $updated_fields;
	}

	public function get_attr($attr){
		return $this->fields[$attr]['value'];
	}

	public function set_attr($attr, $value){
		$this->fields[$attr]['value'] = $value;
		$this->fields[$attr]['updated'] = true;
	}
	
	public function get_fields_names(){ return array_keys($this->fields);}
	
	public function get_fields(){
		$fields = array();
		foreach ($fields as $key => $val) {
			$fields[$key] = $val['value'];
		}
		return $fields;
	}
	
	public function fill_fields($fields) {
		$this->fields = array();
		foreach ($fields as $key => $value) {
			$this->fields[$key] = array(
				'value' => $value,
				'updated' =>false
			);
		}
	}

	public function get_id(){
		return (int) $this->fields['id']['value'];
	}
}
