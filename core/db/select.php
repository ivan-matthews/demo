<?php

	/*
		DB::select('*')
			->from('routes')
			->where("`routes_url`=DATA")
			->order('routes_url','DESC')
			->data(array('DATA'=>'exit'))
			->limit(1)
			->offset(0)
//			->join('users','auth_id=users_id')
			->getItemAsArray()
	*/

	namespace Core\DB;

	use Core\Classes\DB;

	class Select{

		private static $instance;

		private $db;
		private $db_object;

		protected $select;

		protected $fields;
		protected $table;
		protected $where;
		protected $nested_query;
		protected $join = array();
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
			if(isset($this->select[$key])){
				return $this->select[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->select[$name] = $value;
			return $this->select[$name];
		}

		public function __construct(){
			$this->db = DB::getInstance();
			$this->db_object = $this->db->getDbObject();
		}

		public function __destruct(){

		}

		public function setFields($fields){
			$this->fields = $fields;
			return $this;
		}

		public function from(...$table){
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

		public function join($table,$query,$type='LEFT'){
			$this->join[] = array(
				'table' => $table,
				'query' => $query,
				'type'	=> $type
			);
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
			$result = $this->db_object->select(
				$this->fields,
				$this->table,
				$this->where,
				$this->nested_query,
				$this->join,
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
			$this->fields = null;
			$this->table = null;
			$this->where = null;
			$this->nested_query = null;
			$this->join = array();
			$this->limit = null;
			$this->offset = null;
			$this->order_by = null;
			$this->group_by = null;
			$this->preparing_data = array();
			return $this;
		}

		public function getArray(){
			$result = $this->exec();
			if($result){
				return $this->db_object->getArray($result);
			}
			return false;
		}
		public function getObject(){
			$result = $this->exec();
			if($result){
				return $this->db_object->getObject($result);
			}
			return false;
		}
		public function getItemAsArray(){
			$result = $this->exec();
			if($result){
				return $this->db_object->getItemAsArray($result);
			}
			return false;
		}
		public function getItemAsObject(){
			$result = $this->exec();
			if($result){
				return $this->db_object->getItemAsObject($result);
			}
			return false;
		}


















	}














