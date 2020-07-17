<?php

	/*
		DB::update('controllers')
			->field('controllers_name','32')
			->field('controllers_status','dsfa')
			->query('controllers_visible_name',"(SELECT users_first_name FROM users WHERE users_id=USERS_ID)")
			->where("`controllers_id`=controllers_id_replace_data")
			->data(array('controllers_id_replace_data'=>5,'USERS_ID'=>2))
//			->limit(1)
			->join('users','users_id=controllers_id')
			->join('auth','auth_id=users_id')
			->join('photos','auth_id=photos_id')
			->join('status','photos_id=status_id')
			->offset(0)
			->getRows()
	*/

	namespace Core\DB;

	use Core\Classes\DB;

	class Update{

		private static $instance;

		private $db;
		private $db_object;

		protected $update;

		protected $field;
		protected $table;
		protected $where;
		protected $nested_query;
		protected $join = array();
		protected $limit;
		protected $offset;
		protected $preparing_data=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->update[$key])){
				return $this->update[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->update[$name] = $value;
			return $this->update[$name];
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

		public function field($field,$value){
			$this->field[$field] = $value;
			return $this;
		}

		public function where($query){
			$this->where = $query;
			return $this;
		}

		public function query($field,$nested_query){
			$this->nested_query[$field] = $nested_query;
			return $this;
		}

		public function limit($limit=1){
			$this->limit = $limit;
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

		public function offset($offset=0){
			$this->offset = $offset;
			return $this;
		}

		public function data($replace_data=array()){
			$this->preparing_data = $replace_data;
			return $this;
		}

		public function exec(){
			$result = $this->db_object->update(
				$this->field,
				$this->table,
				$this->where,
				$this->nested_query,
				$this->join,
				$this->limit,
				$this->offset,
				$this->preparing_data
			);

			$this->removeProps();
			return $result;
		}

		protected function removeProps(){
			$this->table = null;
			$this->where = null;
			$this->nested_query = null;
			$this->join = array();
			$this->limit = null;
			$this->offset = null;
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














