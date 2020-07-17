<?php

	/*
		Database::select('*')
			->from('users')
			->where("`users_id`=UID")
			->order('users_id','DESC')
			->data('UID',1)
			->limit(1)
			->offset(0)
			->join('auth','auth_id=users_id','right')
			->getItemAsArray()
	*/

	namespace Core\Database;

	use Core\Classes\Database;

	class Select{

		private $database;
		private $database_object;

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

		public function __construct(Database $database){
			$this->database = $database;
			$this->database_object = $this->database->getDbObject();
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

		public function data($key,$value){
			$this->preparing_data[$key] = $value;
			return $this;
		}

		public function exec(){
			$result = $this->database_object->select(
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

		public function getAll($resulttype=MYSQLI_ASSOC){
			$result = $this->exec();
			if($result){
				return $this->database_object->getAll($result,$resulttype);
			}
			return false;
		}
		public function getArray(){
			$result = $this->exec();
			if($result){
				return $this->database_object->getArray($result);
			}
			return false;
		}
		public function getObject(){
			$result = $this->exec();
			if($result){
				return $this->database_object->getObject($result);
			}
			return false;
		}
		public function getItemAsArray(){
			$result = $this->exec();
			if($result){
				return $this->database_object->getItemAsArray($result);
			}
			return false;
		}
		public function getItemAsObject(){
			$result = $this->exec();
			if($result){
				return $this->database_object->getItemAsObject($result);
			}
			return false;
		}


















	}














