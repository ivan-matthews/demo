<?php

	/*
		DB::delete()
			->where("`controllers_id`=DATA")
			->order('controllers_name','DESC')
			->data(array('DATA'=>5))
			->limit(1)
			->offset(0)
//			->using('users')
			->getRows()
	*/

	namespace Core\DB;

	use Core\Classes\DB;

	class Delete{

		private static $instance;

		private $db;
		private $db_object;

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

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->delete[$key])){
				return $this->delete[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->delete[$name] = $value;
			return $this->delete[$name];
		}

		public function __construct(){
			$this->db = DB::getInstance();
			$this->db_object = $this->db->getDbObject();
		}

		public function __destruct(){

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

		public function data($replace_data=array()){
			$this->preparing_data = $replace_data;
			return $this;
		}

		public function exec(){
			$result = $this->db_object->delete(
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

			$this->removeProps();
			return $result;
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

		public function getRows(){
			$result = $this->exec();
			if($result){
				return $this->db_object->affectedRows();
			}
			return null;
		}


















	}














