<?php

	/*
		$insert = Database::insert('controllers');
		for($i=0;$i<3;$i++){
			$insert->value('controllers_id',rand(1,5));
			$insert->value('controllers_name',rand(1,999999999).'er');
			$insert->value('controllers_visible_name','test');
			$insert->value('controllers_status',Kernel::STATUS_ACTIVE);
			$insert->value('controllers_enabled_groups',null);
			$insert->value('controllers_disabled_groups',null);
			$insert->value('controllers_options',null);
			$insert->query('test',"(SELECT * FROM test_table LIMIT 1)");
		}
		$insert->update('controllers_disabled_groups',rand(4,555));
		$insert->updateQuery('test',"(SELECT count_field_total FROM test_table WHERE id=ID LIMIT 1)");
		$insert->data('ID',213);
		fx_pre($insert->getId());

	||

		for($i=0;$i<3;$i++) {
			$insert = Database::insert('controllers')
				->value('controllers_id', rand(1, 5))
				->value('controllers_name', rand(1, 999999999) . 'er')
				->value('controllers_visible_name', 'test')
				->value('controllers_status', Kernel::STATUS_ACTIVE)
				->value('controllers_enabled_groups', null)
				->value('controllers_disabled_groups', null)
				->value('controllers_options', null)

//				->query('test',"(SELECT * FROM test_table LIMIT 1)")
				->update('controllers_disabled_groups', rand(4, 555))
//				->updateQuery('test',"(SELECT count_field_total FROM test_table WHERE id=ID LIMIT 1)")

				->data('ID',213);
			fx_pre($insert->getId());
		}
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Database\Connect\MySQLi;
	use Core\Classes\Database\Interfaces\Insert\Insert as InsertInterface;

	class Insert implements InsertInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;

		protected $insert;

		protected $table;
		protected $fields;
		protected $nested_query;
		protected $update;
		protected $update_nested_query;
		protected $preparing_data;

		/** @var  object */
		protected $result;

		public function __construct(Database $database){
			$this->database = $database;
		}

		public function __destruct(){
			unset($this->database);
			unset($this->database_object);
			unset($this->insert);
			unset($this->table);
			unset($this->fields);
			unset($this->nested_query);
			unset($this->update);
			unset($this->update_nested_query);
			unset($this->preparing_data);
			unset($this->result);
		}

		private function connect(){
			$this->database_object = $this->database->getDbObject();
			return $this;
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

		public function data($key,$value){
			$this->preparing_data[$key] = $value;
			return $this;
		}

		public function exec(){
			$this->connect();
			$this->result = $this->database_object
				->insert(
					$this->table,
					$this->fields,
					$this->nested_query,
					$this->update,
					$this->update_nested_query,
					$this->preparing_data
				);
//			$this->removeProps();
			return $this->result;
		}

		protected function removeProps(){
			$this->table = null;
			$this->fields = null;
			$this->nested_query = null;
			$this->update = null;
			$this->update_nested_query = null;
			$this->preparing_data = null;
			$this->result = null;
			return $this;
		}

		public function id(){
			if($this->result){
				return $this->database_object->lastId();
			}
			return null;
		}

		public function get(){
			$this->exec();
			return $this;
		}











	}














