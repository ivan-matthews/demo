<?php

	#CMD: php cli make db_alter [table_name, table_description]
	#DSC: create new migrations alter table class
	#EXM: php cli make db_alter users add_new_field_friends

	namespace System\Console\Make;

	use Core\Classes\Console;
	use Core\Classes\Paint;

	class DB_Alter extends Console{

		private $class_prefix;
		private $file_prefix;

		private $migrations_folder;
		private $migration_file;

		private $table_name;
		private $second_argument;

		protected $time;
		protected $date;

		protected $class_name;
		protected $file_name;

		protected $file_data;
		protected $replaced_file_data;

		protected $result;

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

		protected function getClassName(){
			$class_name = "{$this->class_prefix}_{$this->table_name}_{$this->second_argument}_{$this->date}_{$this->time}";
			$class_name = fx_array_callback(explode("_",$class_name), function(&$key,&$value){
				$value = ucfirst($value);
			});
			$this->class_name = implode('',$class_name);
			return $this;
		}

		protected function getFileName(){
			$table_name = mb_strtolower($this->table_name);
			$second_argument = mb_strtolower($this->second_argument);
			$this->file_name = "{$this->date}_{$this->file_prefix}_{$table_name}_{$second_argument}_{$this->time}";
			return $this;
		}

		protected function getClassData(){
			$this->file_data = file_get_contents(fx_php_path("system/console/make/templates/alterClass.tmp"));
			return $this;
		}

		protected function getReplacedData(){
			$this->replaced_file_data = str_replace(array(
				'__table_name__','__class_name__'
			),array(
				$this->table_name,$this->class_name
			),$this->file_data);
			return $this;
		}

		protected function getFilePath(){
			$this->migration_file = "{$this->migrations_folder}/{$this->file_name}.php";
			return $this;
		}

		protected function saveNewClass(){
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


		protected function errorMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('ERROR')->color('red')->toPaint();
				$paint->string(': File ')->toPaint();
				$paint->string("{$this->class_name}")->color('cyan')->toPaint();
				$paint->string(' has been created in ')->toPaint();
				$paint->string("{$this->migration_file}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}

		protected function alreadyMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('WARNING')->color('yellow')->toPaint();
				$paint->string(': File ')->toPaint();
				$paint->string("{$this->class_name}")->color('cyan')->toPaint();
				$paint->string(' has been created in ')->toPaint();
				$paint->string("{$this->migration_file}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}

		protected function successfulMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('SUCCESS')->color('green')->toPaint();
				$paint->string(': File ')->toPaint();
				$paint->string("{$this->class_name}")->color('cyan')->toPaint();
				$paint->string(' has been created in ')->toPaint();
				$paint->string("{$this->migration_file}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}


















	}














