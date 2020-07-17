<?php

	/*
		Database::delete()
			->where("`controllers_id`=DATA")
			->order('controllers_name','DESC')
			->data('DATA',5)
			->limit(1)
			->offset(0)
//			->using('users')
			->getRows()
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Database;
	use Core\Classes\Database\Connect\MySQLi;
	use Core\Classes\Database\Interfaces\Delete\Delete as DeleteInterface;

	class Delete implements DeleteInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;

		protected $delete;

		protected $fields;
		protected $table;
		protected $where;
		protected $nested_query;
		protected $using_tables;
		protected $limit;
		protected $offset;
		protected $order_by=array();
		protected $group_by;
		protected $preparing_data=array();

		/** @var  object */
		private $result;

		public function __construct(Database $database){
			$this->database = $database;
		}

		private function connect(){
			$this->database_object = $this->database->getDbObject();
			return $this;
		}

		public function setTable($table){
			$this->table = $table;
			return $this;
		}

		public function where($query){
			$this->where = $query;
			return $this;
		}

		public function query($nested_query){
			$this->nested_query = $nested_query;
			return $this;
		}

		public function using(...$tables){
			$this->using_tables = $tables;
			return $this;
		}

		public function limit($limit=1){
			$this->limit = $limit;
			return $this;
		}

		public function offset($offset=0){
			$this->offset = $offset;
			return $this;
		}

		public function order(...$order){
			$this->order_by = $order;
			return $this;
		}

		public function group(...$group){
			$this->group_by = $group;
			return $this;
		}

		public function data($key,$value){
			$this->preparing_data[$key] = $value;
			return $this;
		}

		public function exec(){
			$this->connect();
			$this->result = $this->database_object->delete(
				$this->table,
				$this->where,
				$this->nested_query,
				$this->using_tables,
				$this->limit,
				$this->offset,
				$this->order_by,
				$this->group_by,
				$this->preparing_data
			);

//			$this->removeProps();
			return $this->result;
		}

		protected function removeProps(){
			$this->table = null;
			$this->where = null;
			$this->nested_query = null;
			$this->using_tables = null;
			$this->limit = null;
			$this->offset = null;
			$this->order_by = null;
			$this->group_by = null;
			$this->preparing_data = array();
			return $this;
		}

		public function rows(){
			if($this->result){
				return $this->database_object->affectedRows();
			}
			return null;
		}

		public function get(){
			$this->exec();
			return $this;
		}

















	}














