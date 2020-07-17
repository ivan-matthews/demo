<?php

	/*

		$table = $model->makeTable('dddd');
		$table->bigint('id')->unsigned()->primary()->autoIncrement();

		$table->varchar('first_name')->index()->nullable();
		$table->varchar('phone',20)->index()->nullable();
		$table->int('birth_day',2)->index()->nullable();
		$table->longtext('activities')->fullText()->nullable();
		$table->bigint('date_log')->index()->nullable();
		$table->varchar('log_type')->index()->nullable();
		$table->varchar('type')->index()->defaults('u');

		$table->add_timestamps(); // added fields `date_created`, `date_updated`, `date_deleted`
		$table->exec();

	*/

	/*
		\Core\Controllers\Home\Model::getInstance()->cache
			->key('someone.cache.key')
			->index(2) // default: 2
			->get();
	*/

	namespace Core\Classes;

	use Core\Cache\Cache;
	use Core\Database\Query;
	use Core\Database\Select;
	use Core\Database\Insert;
	use Core\Database\Update;
	use Core\Database\Alter;
	use Core\Database\Create;
	use Core\Database\Delete;

	class Model{

		private static $instance;

		protected $model;
		protected $database;
		public $cache;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->model[$key])){
				return $this->model[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->model[$name] = $value;
			return $this->model[$name];
		}

		public function __construct(){
			$this->database = Database::getInstance();
			$this->cache = Cache::getInstance();
		}

		public function __destruct(){

		}

		public function query($query){
			$obj = new Query($this->database);
			$obj->setQuery($query);
			return $obj;
		}

		public function alterTable($table){
			$obj = new Alter($table,$this->database);
			return $obj;
		}

		public function makeTable($table){
			$obj = new Create($table,$this->database);
			return $obj;
		}

		public function delete(...$from_tables){
			$obj = new Delete($this->database);
			$obj->setTable($from_tables);
			return $obj;
		}

		public function insert($to_table){
			$obj = new Insert($this->database);
			$obj->setTable($to_table);
			return $obj;
		}

		public function select(...$fields){
			$obj = new Select($this->database);
			$obj->setFields($fields);
			return $obj;
		}

		public function update($in_table){
			$obj = new Update($this->database);
			$obj->setTable($in_table);
			return $obj;
		}


		public function showIndex($table){
			return $this->database->showIndex($table);
		}

		public function dropTable(...$tables){
			return $this->database->dropTable(...$tables);
		}

		public function truncate(...$tables){
			return $this->database->truncate(...$tables);
		}

		public function showTables($database=false){
			return $this->database->showTables($database);
		}

		public function showDBs(){
			return $this->database->showDBs();
		}

		public function dropDb($database_name){
			return $this->database->dropDb($database_name);
		}

		public function makeDb($new_database_name){
			return $this->database->makeDb($new_database_name);
		}

		public function setCharset($charset){
			return $this->database->setCharset($charset);
		}

		public function setCollate($collate){
			return $this->database->setCollate($collate);
		}

















	}














