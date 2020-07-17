<?php

	#CMD: make db_alter [table_name], [table_description]
	#DSC: cli.alter_migration_table
	#EXM: make db_alter users add_field_id

	namespace System\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class DB_Alter extends Console{

		private $class_prefix;
		private $file_prefix;

		private $migrations_folder;
		private $migration_file;

		private $table_name;
		private $second_argument;

		private $time;
		private $date;

		private $class_name;
		private $file_name;

		private $file_data;
		private $replaced_file_data;

		public function execute($table_name,$second_argument=null){
			$this->migrations_folder = fx_path("system/migrations");

			$this->class_prefix = "AlterTable";
			$this->file_prefix = "alter_table";

			$this->table_name = $table_name;
			$this->second_argument = $second_argument;

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

		private function getClassName(){
			$class_name = "{$this->class_prefix}_{$this->table_name}_{$this->second_argument}_{$this->date}_{$this->time}";
			$class_name = fx_array_callback(explode("_",$class_name), function(&$key,&$value){
				$value = ucfirst($value);
			});
			$this->class_name = implode('',$class_name);
			return $this;
		}

		private function getFileName(){
			$table_name = mb_strtolower($this->table_name);
			$second_argument = mb_strtolower($this->second_argument);
			$this->file_name = "{$this->date}_{$this->file_prefix}_{$table_name}_{$second_argument}_{$this->time}";
			return $this;
		}

		private function getClassData(){
			$this->file_data = file_get_contents(fx_php_path("system/console/make/templates/alterClass.tmp"));
			return $this;
		}

		private function getReplacedData(){
			$this->replaced_file_data = str_replace(array(
				'__table_name__','__class_name__'
			),array(
				$this->table_name,$this->class_name
			),$this->file_data);
			return $this;
		}

		private function getFilePath(){
			$this->migration_file = "{$this->migrations_folder}/{$this->file_name}.php";
			return $this;
		}

		private function saveNewClass(){
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

		private function errorMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.error_header'))->color('red')->toPaint();
				$print->string(fx_lang('cli.class_not_created',array(
					'CLASS_NAME'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'CLASS_FILE'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function alreadyMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.warning_header'))->color('yellow')->toPaint();
				$print->string(fx_lang('cli.class_already_created',array(
					'CLASS_NAME'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'CLASS_FILE'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function successfulMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.success_header'))->color('green')->toPaint();
				$print->string(fx_lang('cli.class_success_created',array(
					'CLASS_NAME'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'CLASS_FILE'	=> $print->string("{$this->migration_file}")->color('white')->fon('blue')->get(),
				)))->toPaint();
				$print->eol();
			});
			return $this;
		}


















	}














