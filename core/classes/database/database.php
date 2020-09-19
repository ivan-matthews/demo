<?php

	/*
		$database = Database::getInstance();
		fx_pre($database->getDbObject());

		$database->setDbDriver('PgSQL');
		$database->setDbObject();

		fx_pre($database->getDbObject());
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Config;

	class Database{

		private static $instance;

		protected $database;

		private $config;
		private $database_driver;
		/** @var \Core\Classes\Database\Connect\MySQL */
		private $database_object;

		private $charset;
		private $collate;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->database[$key])){
				return $this->database[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->database[$name] = $value;
			return $this->database[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->database_driver = $this->config->core['db_driver'];
		}

		public function __destruct(){

		}

		/**
		 * @param $query
		 * @return \Core\Classes\Database\Interfaces\Query\Query
		 */
		public static function query($query){
			$obj = new Query(self::getInstance());
			$obj->setQuery($query);
			return $obj;
		}

		public static function alterTable($table, callable $callback_function){
			$obj = new Alter($table,self::getInstance());
			call_user_func($callback_function,$obj);
			return $obj->exec();
		}

		public static function makeTable($table, callable $callback_function){
			$obj = new Create($table,self::getInstance());
			call_user_func($callback_function,$obj);
			return $obj->exec();
		}

		/**
		 * @param array ...$from_tables
		 * @return \Core\Classes\Database\Interfaces\Delete\Delete
		 */
		public static function delete(...$from_tables){
			$obj = new Delete(self::getInstance());
			$obj->setTable($from_tables);
			return $obj;
		}

		/**
		 * @param $to_table
		 * @return \Core\Classes\Database\Interfaces\Insert\Insert
		 */
		public static function insert($to_table){
			$obj = new Insert(self::getInstance());
			$obj->setTable($to_table);
			return $obj;
		}

		/**
		 * @param array ...$fields
		 * @return \Core\Classes\Database\Interfaces\Select\Select
		 */
		public static function select(...$fields){
			if(!$fields){ $fields = '*'; }
			$obj = new Select(self::getInstance());
			$obj->setFields($fields);
			return $obj;
		}

		/**
		 * @param $in_table
		 * @return \Core\Classes\Database\Interfaces\Update\Update
		 */
		public static function update($in_table){
			$obj = new Update(self::getInstance());
			$obj->setTable($in_table);
			return $obj;
		}

/*-------------------------------------------------------------------------------------------------------------------*/

		public function showColumns($tables){
			return $this
				->getDbObject()
				->showColumns($tables);
		}

		public function showIndex($table){
			return $this
				->getDbObject()
				->showIndex($table);
		}

		public function dropTable(...$tables){
			return $this
				->getDbObject()
				->dropTable($tables);
		}

		public function truncate(...$tables){
			return $this
				->getDbObject()
				->truncateTable($tables);
		}

		public function showTables($database=false){
			return $this
				->getDbObject()
				->showTables($database);
		}

		public function showDBs(){
			return $this
				->getDbObject()
				->showDatabases();
		}

		public function useDb($database){
			return $this
				->getDbObject()
				->selectDB($database);
		}

		public function dropDb($database_name){
			return $this
				->getDbObject()
				->dropDb($database_name);
		}

		/*
			$db = Database::getInstance();
			for($i=0;$i<50;$i++){
				$db->setCharset('utf8mb4');
				$db->setCollate('utf8mb4_unicode_ci');
				$db->makeDb("super_test_new_database_{$i}");
			}
		*/

		public function makeDb($new_database_name){
			$result =  $this
				->getDbObject()
				->makeDb(
					$new_database_name,
					$this->charset,
					$this->collate
				);
			$this->charset = null;
			$this->collate = null;
			return $result;
		}

		public function setCollate($collate){
			$this->collate = $collate;
			return $this;
		}

		public function setCharset($charset){
			$this->charset = $charset;
			return $this;
		}

		public function setDbDriver($driver){
			$this->database_driver = $driver;
			return $this;
		}

		public function setDbObject(){
			if($this->config->core['db_use_pdo']){
				$class_name = "\\Core\\Classes\\Database\\Connect\\PDO\\{$this->database_driver}";
			}else{
				$class_name = "\\Core\\Classes\\Database\\Connect\\{$this->database_driver}";
			}
			$this->database_object = call_user_func(array($class_name,'getInstance'));
			return $this->database_object;
		}

		public function getDbDriver(){
			return $this->database_driver;
		}

		public function getDbObject(){
			if($this->database_object){
				return $this->database_object;
			}
			return $this->setDbObject();
		}










	}














