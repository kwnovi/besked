<?php
require(dirname(__FILE__)."/../database.php");

abstract class Model{

	protected $fields;

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

		$stmt = $this->query("SELECT $fields FROM $table WHERE id = :id LIMIT 1;", array(
					'id' => array(
						'val' => $id,
						'type' => PDO::PARAM_INT
						)
					)
				);
		//$this->fill_fields($this->execute($stmt)[0]);
		return static::__construct_fill_fields($this->execute($stmt)[0]);
	}

	public function save(){

	}

	private function query($query_string, $params){
		$db = Database::getConnection();
		$stmt = $db->prepare($query_string);
		foreach ($params as $key => $val) {
			$stmt->bindParam(":$key", $val['val'], $val['type']);
		}
		return $stmt;
	}

	private function execute($stmt){
		try {
			$stmt->execute();
			// $stmt == false si problème dans la query ou pas de lignes renvoyees
			if (!$stmt) {
				throw new Exception("Not found", 1);
			}
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	// NON TESTE
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
}
