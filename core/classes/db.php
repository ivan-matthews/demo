<?php

	namespace Core\Classes;

	use Core\DB\Select;
	use Core\DB\Insert;
	use Core\DB\Update;
	use Core\DB\Alter;
	use Core\DB\Create;
	use Core\DB\Delete;

	class DB{

		private static $instance;

		protected $db;

		private $config;
		private $db_driver;
		private $db_object;


		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->db[$key])){
				return $this->db[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->db[$name] = $value;
			return $this->db[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->db_driver = $this->config->core['db_driver'];
		}

		public function __destruct(){

		}

		public static function alter($table){
			$obj = Alter::getInstance();

			return $obj;
		}

		public static function create($table){
			$obj = Create::getInstance();

			return $obj;
		}

		public static function delete(...$from_tables){
			$obj = Delete::getInstance();
			$obj->setTable($from_tables);
			return $obj;
		}

		public static function insert($to_table){
			$obj = Insert::getInstance();
			$obj->setTable($to_table);
			return $obj;
		}

		public static function select(...$fields){
			$obj = Select::getInstance();
			$obj->setFields($fields);
			return $obj;
		}

		public static function update($in_table){
			$obj = Update::getInstance();
			$obj->setTable($in_table);
			return $obj;
		}

		/*
			$db = DB::getInstance();
			fx_pre($db->getDbObject());

			$db->setDbDriver('PgSQL');
			$db->setDbObject();

			fx_pre($db->getDbObject());
		*/

		public function setDbDriver($driver){
			$this->db_driver = $driver;
			return $this;
		}

		public function setDbObject(){
			$class_name = "\\Core\\DB\\Connect\\{$this->db_driver}";
			$this->db_object = call_user_func(array($class_name,'getInstance'));
			return $this->db_object;
		}

		public function getDbDriver(){
			return $this->db_driver;
		}

		public function getDbObject(){
			if($this->db_object){
				return $this->db_object;
			}
			return $this->setDbObject();
		}













	}














