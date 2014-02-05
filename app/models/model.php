<?php
require(dirname(__FILE__)."/../database.php");

class Model{

	protected $fields;

	protected static function __construct_fill_fields($fields_values){
		$instance = new self();
		$instance->fields = array();
		foreach ($fields_values as $key => $value) {
			$instance->fields[$key] = array(
				'value' => $value,
				'updated' =>false
			);
		}
		return $instance;
	}

	public function find($id){
		$fields = implode(',', $this->get_fields());
		$table = $this::table_name;

		$stmt = $this->query("SELECT $fields FROM $table WHERE id = :id LIMIT 1;", array(
					'id' => array(
						'val' => $id,
						'type' => PDO::PARAM_INT
						)
					)
				);
		return $this->execute($stmt);
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
			return $stmt->fetchAll();
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
}

?>