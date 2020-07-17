<?php

	#CMD: make db_insert [some_name]
	#DSC: cli.new_insert_item_class
	#EXM: make db_insert add_user_item

	namespace System\Console\Make;

	use Core\Console\Console;
	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;

	class DB_Insert extends Console{

		private $class_prefix;
		private $file_prefix;

		private $inserts_folder;
		private $insert_file;

		private $insert_name;

		private $time;
		private $date;

		private $class_name;
		private $insert_data_to_replace;
		private $file_name;

		private $file_data;
		private $replaced_file_data;

		public function execute($insert_name){
			$this->inserts_folder = fx_path("system/inserts");

			$this->class_prefix = "Insert";
			$this->file_prefix = "insert";

			$this->insert_name = $insert_name;

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
			$class_name = "{$this->class_prefix}_{$this->insert_name}_{$this->date}_{$this->time}";
			$class_name = fx_array_callback(explode("_",$class_name), function(&$key,&$value){
				$value = ucfirst($value);
			});
			$this->class_name = implode('',$class_name);
			return $this;
		}

		private function getFileName(){
			$insert_name = mb_strtolower($this->insert_name);
			$this->file_name = "{$this->date}_{$this->file_prefix}_{$insert_name}_{$this->time}";
			return $this;
		}

		private function getClassData(){
			$this->file_data = file_get_contents(fx_php_path("system/console/make/templates/insertToDbClass.tmp"));
			return $this;
		}

		private function getReplacedData(){
			$this->replaced_file_data = str_replace(array(
				'__class_name__','/*insert data to replace*/'
			),array(
				$this->class_name,$this->insert_data_to_replace
			),$this->file_data);
			return $this;
		}

		public function setInsertDataToReplace($insert_data_to_replace){
			$this->insert_data_to_replace = $insert_data_to_replace;
			return $this;
		}

		private function getFilePath(){
			$this->insert_file = "{$this->inserts_folder}/{$this->file_name}.php";
			return $this;
		}

		private function saveNewClass(){
			fx_make_dir($this->inserts_folder);

			if(!file_exists($this->insert_file)){
				$this->result = file_put_contents($this->insert_file,$this->replaced_file_data);
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
				$print->string('ERROR')->color('red')->toPaint();
				$print->string(': File ')->toPaint();
				$print->string("{$this->class_name}")->color('cyan')->toPaint();
				$print->string(' has been created in ')->toPaint();
				$print->string("{$this->insert_file}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function alreadyMaking(){
			Paint::exec(function(Types $print){
				$print->string('WARNING')->color('yellow')->toPaint();
				$print->string(': File ')->toPaint();
				$print->string("{$this->class_name}")->color('cyan')->toPaint();
				$print->string(' has been created in ')->toPaint();
				$print->string("{$this->insert_file}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function successfulMaking(){
			Paint::exec(function(Types $print){
				$print->string('SUCCESS')->color('green')->toPaint();
				$print->string(': File ')->toPaint();
				$print->string("{$this->class_name}")->color('cyan')->toPaint();
				$print->string(' has been created in ')->toPaint();
				$print->string("{$this->insert_file}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}
















	}














