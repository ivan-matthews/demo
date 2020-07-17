<?php

	#CMD: migration drop_db [database_name]
	#DSC: remove database from databases list
	#EXM: migration drop_db test_db

	namespace System\Console\Migration;

	use Core\Console\Console;
	use Core\Console\Paint;
	use Core\Classes\Database;
	use Core\Classes\Config;

	class Drop_DB extends Console{

		private $config;
		private $database;
		private $db_driver;
		private $db_params;

		private $database_name;

		public function __construct(){
			$this->config = Config::getInstance();
			$this->database = Database::getInstance();
			$this->db_driver = $this->database->getDbDriver();
			$this->db_params = $this->config->database[$this->db_driver];
		}

		public function execute($database_name=false){
			$this->database_name = $database_name;
			$this->getDbName();

			if($this->dropDB()){
				$this->success();
			}else{
				$this->skipped();
			}

			return $this->result;
		}

		private function getDbName(){
			if(!$this->database_name){
				$this->database_name = $this->db_params['base'];
			}
			return $this;
		}

		private function dropDB(){
			return $this->database->dropDb($this->database_name);
		}

		private function success(){
			return Paint::exec(function(Paint $print){
				$print->string('Database "')->toPaint();
				$print->string($this->database_name)->fon('green')->toPaint();
				$print->string('" successful deleted!')->toPaint();
				$print->eol();
			});
		}

		private function skipped(){
			return Paint::exec(function(Paint $print){
				$print->string('Database "')->toPaint();
				$print->string($this->database_name)->fon('red')->toPaint();
				$print->string('" not deleted!')->toPaint();
				$print->eol();
			});
		}
















	}