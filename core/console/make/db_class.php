<?php

	#CMD: make db_class [database]
	#DSC: cli.new_db_connection_class
	#EXM: make db_class PgSQL

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interfaces\Types;

	class DB_Class extends Console{

		public $database;
		public $database_connect_path="core/classes/database/connect";

		public $database_tmp_file;
		public $database_tmp_data;
		public $database_tmp_replaced_data;
		public $database_file_name;
		public $database_class_name;
		public $database_config_key;

		public function execute($database){
			$this->database	= $database;
			$this->database_file_name = strtolower($database);
			$this->database_class_name = $database;
			$this->database_config_key = $this->database_file_name;
			$this->database_tmp_file = fx_php_path("system/console/databaseClass.tmp");

			$this->getTmpFileData();
			$this->replaceTmpFileData();
			$this->saveTmpReplacedDataToNewFile();

			return $this->result;
		}

		public function saveTmpReplacedDataToNewFile(){
			$file_path = fx_path("{$this->database_connect_path}/{$this->database_file_name}.php");
			if(!file_exists($file_path)){
				file_put_contents($file_path,$this->database_tmp_replaced_data);
				$this->success($file_path,$this->database_class_name);
				return $this;
			}
			$this->skipped($file_path,$this->database_class_name);
			return $this;
		}

		public function replaceTmpFileData(){
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

		public function getTmpFileData(){
			$this->database_tmp_data = file_get_contents($this->database_tmp_file);
			return $this;
		}

		public function success($command_file,$console_command){
			return Paint::exec(function(Types $print)use($command_file,$console_command){
				$print->string(fx_lang('cli.new_db_class_created',array(
					'%CLASS_NAME%' => $print->string($console_command)->fon('green')->get(),
					'%FILE_NAME%' => $print->string($command_file)->color('green')->get(),
				)))->print()->eol();
			});
		}

		public function skipped($command_file,$console_command){
			return Paint::exec(function(Types $print)use($command_file,$console_command){
				$print->string(fx_lang('cli.new_db_class_not_created',array(
					'%CLASS_NAME%' => $print->string($console_command)->fon('red')->get(),
					'%FILE_NAME%' => $print->string($command_file)->color('red')->get(),
				)))->print()->eol();
			});
		}

















	}