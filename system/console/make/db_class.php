<?php

	#CMD: php cli make db_class [database]
	#DSC: create new connection database class (MySQL,PgSQL,JDB,PDO,Mongo, etc...)
	#EXM: php cli make db_class PgSQL

	namespace System\Console\Make;

	use Core\Classes\Console;
	use Core\Classes\Paint;

	class DB_Class extends Console{

		protected $database;
		protected $database_connect_path="core/database/connect";

		protected $database_tmp_file;
		protected $database_tmp_data;
		protected $database_tmp_replaced_data;
		protected $database_file_name;
		protected $database_class_name;
		protected $database_config_key;

		protected $result = true;

		public function execute($database){
			$this->database	= $database;
			$this->database_file_name = strtolower($database);
			$this->database_class_name = $database;
			$this->database_config_key = $this->database_file_name;
			$this->database_tmp_file = fx_php_path("system/console/make/templates/databaseClass.tmp");

			$this->getTmpFileData();
			$this->replaceTmpFileData();
			$this->saveTmpReplacedDataToNewFile();

			return $this->result;
		}

		protected function saveTmpReplacedDataToNewFile(){
			$file_path = fx_path("{$this->database_connect_path}/{$this->database_file_name}.php");
			if(!file_exists($file_path)){
				file_put_contents($file_path,$this->database_tmp_replaced_data);
				$this->success($file_path,$this->database_class_name);
				return $this;
			}
			$this->skipped($file_path,$this->database_class_name);
			return $this;
		}

		protected function replaceTmpFileData(){
			$this->database_tmp_replaced_data = str_replace(
				array(
					'__class_name__',
					'__db_class_key__',
				),
				array(
					$this->database_class_name,
					$this->database_config_key,
				),
				$this->database_tmp_data
			);
			return $this;
		}

		protected function getTmpFileData(){
			$this->database_tmp_data = file_get_contents($this->database_tmp_file);
			return $this;
		}

		protected function success($command_file,$console_command){
			return Paint::exec(function(Paint $print)use($command_file,$console_command){
				$print->string('New Database Class "')->toPaint();
				$print->string($console_command)->fon('green')->toPaint();
				$print->string('" successful save to ')->toPaint();
				$print->string($command_file)->color('green')->toPaint();
				$print->eol();
			});
		}

		protected function skipped($command_file,$console_command){
			return Paint::exec(function(Paint $print)use($command_file,$console_command){
				$print->string('Database Class "')->toPaint();
				$print->string($console_command)->fon('red')->toPaint();
				$print->string('" already exists in ')->toPaint();
				$print->string($command_file)->color('red')->toPaint();
				$print->eol();
			});
		}

















	}