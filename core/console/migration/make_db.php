<?php

	#CMD: migration make_db [database_name]
	#DSC: cli.make_new_database
	#EXM: migration make_db test_db

	namespace Core\Console\Migration;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Database\Database;
	use Core\Classes\Config;

	class Make_DB extends Console{

		public $config;
		public $database;
		public $db_driver;
		public $db_params;

		public $database_name;

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

		public function getDbName(){
			if(!$this->database_name){
				$this->database_name = $this->db_params['base'];
			}
			return $this;
		}

		public function dropDB(){
			return $this->database
				->setCharset($this->db_params['sql_charset'])
				->setCollate($this->db_params['collate'])
				->makeDb($this->database_name);
		}

		public function success(){
			return Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.database_created',array(
					'%DATABASE%'	=> $print->string($this->database_name)->fon('green')->get()
				)))->print()->eol();
			});
		}

		public function skipped(){
			return Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.database_not_created',array(
					'%DATABASE%'	=> $print->string($this->database_name)->fon('red')->get()
				)))->print()->eol();
			});
		}
















	}