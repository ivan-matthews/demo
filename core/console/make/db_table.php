<?php

	#CMD: make db_table [table_name]
	#DSC: cli.create_migration_table
	#EXM: make db_table users

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class DB_Table extends Console{

		public $class_prefix;
		public $file_prefix;

		public $migrations_folder;
		public $migration_file;

		public $table_name;

		public $time;
		public $date;

		public $class_name;
		public $file_name;

		public $file_data;
		public $replaced_file_data;

		public function execute($table_name){
			$this->migrations_folder = fx_path("system/migrations");

			$this->class_prefix = "CreateTable";
			$this->file_prefix = "create_table";

			$this->table_name = $table_name;

			$this->date = date('Y_m_d_his');
			$this->time = time();

			$this->getClassName();
			$this->getFileName();
			$this->getClassData();
			$this->getReplacedData();
			$this->getFilePath();
			$this->saveNewClass();

			return $this->result;
		}

		public function getClassName(){
			$class_name = "{$this->class_prefix}_{$this->table_name}_{$this->date}_{$this->time}";
			$class_name = fx_array_callback(explode("_",$class_name), function(&$key,&$value){
				$value = ucfirst($value);
			});
			$this->class_name = implode('',$class_name);
			return $this;
		}

		public function getFileName(){
			$table_name = mb_strtolower($this->table_name);
			$this->file_name = "{$this->date}_{$this->file_prefix}_{$table_name}_{$this->time}";
			return $this;
		}

		public function getClassData(){
			$this->file_data = file_get_contents(fx_php_path("system/console/tableClass.tmp"));
			return $this;
		}

		public function getReplacedData(){
			$this->replaced_file_data = str_replace(array(
				'__table_name__','__class_name__'
			),array(
				$this->table_name,$this->class_name
			),$this->file_data);
			return $this;
		}

		public function getFilePath(){
			$this->migration_file = "{$this->migrations_folder}/{$this->file_name}.php";
			return $this;
		}

		public function saveNewClass(){
			fx_make_dir($this->migrations_folder);

			if(!file_exists($this->migration_file)){
				$this->result = file_put_contents($this->migration_file,$this->replaced_file_data);
				if($this->result){
					$this->successfulMaking();
				}else{
					$this->errorMaking();
				}
			}else{
				$this->alreadyMaking();
			}

			return $this;
		}
		
		public function errorMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.error_header'))->color('red')->print()->space();
				$print->string(fx_lang('cli.class_not_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}

		public function alreadyMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.warning_header'))->color('yellow')->print()->space();
				$print->string(fx_lang('cli.class_already_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}

		public function successfulMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.success_header'))->color('green')->print()->space();
				$print->string(fx_lang('cli.class_success_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}
















	}














