<?php

	/*
		fx_pre(
			Database::query(
				"SELECT * FROM users
				LEFT JOIN auth ON auth_id=users_id
				WHERE `users_id`=UID
				ORDER BY users_id DESC
				LIMIT 1
	OFFSET 0;"
			)
				->data('UID',5)
				->getArray()
		);
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Connect\MySQLi;
	use Core\Classes\Database\Interfaces\Query\Query as QueryInterface;

	class Query implements QueryInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;

		protected $query;
		protected $query_string;
		protected $preparing_data;

		/** @var  object */
		protected $result;

		public function __construct(Database $database){
			$this->database = $database;
		}

		private function connect(){
			$this->database_object = $this->database->getDbObject();
			return $this;
		}

		public function setQuery($query){
			$this->query_string = $query;
			return $this;
		}

		public function data($key,$value){
			$this->preparing_data[$key] = $value;
			return $this;
		}

		public function exec(){
			$this->connect();
			$this->query_string = trim($this->query_string,"\n ;");
			$this->query_string = "{$this->query_string};";
			$this->result = $this->database_object->exec(
				$this->query_string,
				$this->preparing_data
			);
//			$this->removeProps();
			return $this->result;
		}

		protected function removeProps(){
			$this->preparing_data = null;
			$this->query_string = null;
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
		public function rows(){
			if($this->result){
				return $this->database_object->affectedRows();
			}
			return null;
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














