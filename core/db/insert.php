<?php

	/*
		$insert = DB::insert('controllers');
		for($i=0;$i<3;$i++){
			$insert->value('controllers_id',rand(1,5));
			$insert->value('controllers_name',rand(1,999999999).'er');
			$insert->value('controllers_visible_name','erwe');
			$insert->value('controllers_status','active');
			$insert->value('controllers_enabled_groups',null);
			$insert->value('controllers_disabled_groups',null);
			$insert->value('controllers_options',null);
			$insert->query('test',"(SELECT * FROM test_table LIMIT 1)");
		}
		$insert->update('controllers_disabled_groups',rand(4,555));
		$insert->updateQuery('test',"(SELECT count_field_total FROM test_table WHERE id=ID LIMIT 1)");
		$insert->data(array('ID'=>213));
		fx_pre($insert->getId());
	*/

	namespace Core\DB;

	use Core\Classes\DB;

	class Insert{

		private static $instance;

		private $db;
		private $db_object;

		protected $insert;

		protected $table;
		protected $fields;
		protected $nested_query;
		protected $update;
		protected $update_nested_query;
		protected $preparing_data;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->insert[$key])){
				return $this->insert[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->insert[$name] = $value;
			return $this->insert[$name];
		}

		public function __construct(){
			$this->db = DB::getInstance();
			$this->db_object = $this->db->getDbObject();
		}

		public function __destruct(){

		}

		public function setTable($table){
			$this->table = $table;
			return $table;
		}

		public function value($field,$value){
			$this->fields[$field][] = $value;
			return $this;
		}

		public function query($field,$query){
			$this->nested_query[$field][] = $query;
			return $this;
		}

		public function update($field,$value){
			$this->update[$field] = $value;
			return $this;
		}

		public function updateQuery($field,$query){
			$this->update_nested_query[$field] = $query;
			return $this;
		}

		public function data($replace_data=array()){
			$this->preparing_data = $replace_data;
			return $this;
		}

		public function getId(){
			$result = $this->db_object
				->insert(
					$this->table,
					$this->fields,
					$this->nested_query,
					$this->update,
					$this->update_nested_query,
					$this->preparing_data
				);
			$this->removeProps();
			return $result;
		}

		protected function removeProps(){
			$this->table = null;
			$this->fields = null;
			$this->nested_query = null;
			$this->update = null;
			$this->update_nested_query = null;
			$this->preparing_data = null;
			return $this;
		}












	}














