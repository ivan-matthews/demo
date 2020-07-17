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

	namespace Core\Database;

	use Core\Classes\Database;

	class Query{

		private $database;
		private $database_object;

		protected $query;
		protected $query_string;
		protected $preparing_data;

		public function __construct(Database $database){
			$this->database = $database;
			$this->database_object = $this->database->getDbObject();
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
			$this->query_string = trim($this->query_string,"\n ;");
			$this->query_string = "{$this->query_string};";
			$result = $this->database_object->exec(
				$this->query_string,
				$this->preparing_data
			);
			$this->removeProps();
			return $result;
		}

		protected function removeProps(){
			$this->preparing_data = null;
			$this->query_string = null;
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

		public function getRows(){
			$result = $this->exec();
			if($result){
				return $this->database_object->affectedRows();
			}
			return null;
		}

		public function getId(){
			$result = $this->exec();
			if($result){
				return $this->database_object->lastId();
			}
			return null;
		}


















	}














