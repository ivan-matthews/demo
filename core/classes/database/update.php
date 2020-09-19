<?php

	/*
		Database::update('controllers')
			->field('controllers_name','32')
			->field('controllers_status','test')
			->query('controllers_visible_name',"(SELECT users_first_name FROM users WHERE users_id=USERS_ID)")
			->where("`controllers_id`=controllers_id_replace_data")
			->data('controllers_id_replace_data',5)
			->data('USERS_ID',5)
//			->limit(1)
			->join('users','users_id=controllers_id')
			->join('auth','auth_id=users_id')
			->join('photos','auth_id=photos_id')
			->join('status','photos_id=status_id')
			->offset(0)
			->getRows()
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Database\Connect\MySQL;
	use Core\Classes\Database\Interfaces\Update\Update as UpdateInterface;

	class Update implements UpdateInterface{

		private $database;
		/** @var MySQL */
		private $database_object;

		protected $update;

		protected $field;
		protected $table;
		protected $where;
		protected $nested_query;
		protected $join = array();
		protected $limit;
		protected $offset;
		protected $order_by=array();
		protected $sorting='ASC';
		protected $group_by;
		protected $preparing_data=array();

		/** @var object */
		protected $result;

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

		public function order(...$order){
			$this->order_by = $order;
			return $this;
		}

		public function sort($sorting='ASC'){
			$this->sorting = $sorting;
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

		public function prepare(array $preparing_data){
			$this->preparing_data = $preparing_data;
			return $this;
		}

		public function exec(){
			$this->connect();
			$this->result = $this->database_object->update(
				$this->field,
				$this->table,
				$this->where,
				$this->nested_query,
				$this->join,
				$this->limit,
				$this->offset,
				$this->order_by,
				$this->sorting,
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
			$this->join = array();
			$this->limit = null;
			$this->offset = null;
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














