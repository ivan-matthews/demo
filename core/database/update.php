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

	namespace Core\Database;

	use Core\Classes\Database;

	class Update{

		private $database;
		private $database_object;

		protected $update;

		protected $field;
		protected $table;
		protected $where;
		protected $nested_query;
		protected $join = array();
		protected $limit;
		protected $offset;
		protected $preparing_data=array();

		public function __construct(Database $database){
			$this->database = $database;
			$this->database_object = $this->database->getDbObject();
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

		public function data($key,$value){
			$this->preparing_data[$key] = $value;
			return $this;
		}

		public function exec(){
			$result = $this->database_object->update(
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
				return $this->database_object->affectedRows();
			}
			return null;
		}


















	}














