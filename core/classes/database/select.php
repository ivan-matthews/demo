<?php

	/*
		$db = Database::select();
		fx_pre(array(
			$db->from('user_groups')->where("`id`=5")->get()->all(),
			$db->from('cron_tasks')->where(null)->get()->all(),
		));
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Connect\MySQLi;
	use Core\Classes\Database\Interfaces\Select\Select as SelectInterface;

	class Select implements SelectInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;

		protected $select;

		/** @var  object */
		protected $result;
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
		}

		private function connect(){
			$this->database_object = $this->database->getDbObject();
			return $this;
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
			$this->connect();
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

//			$this->removeProps();
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

//		public function sql(){			// cache-key
//			$hash_array = array(
//				'fields' => $this->fields,
//				'table' => $this->table,
//				'where' => $this->where,
//				'nested' => $this->nested_query,
//				'join' => $this->join,
//				'limit' => $this->limit,
//				'offset' => $this->offset,
//				'order' => $this->order_by,
//				'group' => $this->group_by,
//				'data' => $this->preparing_data
//			);
//			fx_array_callback_recursive($hash_array,function($key,$value)use(&$str){
//				$str .= "{$key}:{$value}|";
//			});
//			return trim($str,'|');
//		}

















	}














