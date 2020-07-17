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
			->get()
			->allAsArray()
	*/

	namespace Core\Database;

	use Core\Classes\Database;
	use Core\Database\Interfaces\Select\Select as SelectInterface;

	class Select implements SelectInterface{

		private $database;
		private $database_object;

		protected $select;

		protected $result=array();
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
			$this->result = $this->database_object->select(
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
			return $this->result;
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

		public function all($resulttype=MYSQLI_ASSOC){
			if($this->result){
				return $this->database_object->getAll($this->result,$resulttype);
			}
			return array();
		}
		public function allAsArray(){
			if($this->result){
				return $this->database_object->getArray($this->result);
			}
			return array();
		}
		public function allAsObject(){
			if($this->result){
				return $this->database_object->getObject($this->result);
			}
			return array();
		}
		public function itemAsArray(){
			if($this->result){
				return $this->database_object->getItemAsArray($this->result);
			}
			return array();
		}
		public function itemAsObject(){
			if($this->result){
				return $this->database_object->getItemAsObject($this->result);
			}
			return array();
		}
		public function get(){
			$this->exec();
			return $this;
		}

















	}














