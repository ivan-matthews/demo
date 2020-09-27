<?php

	#CMD: make db_insert [some_name]
	#DSC: cli.new_insert_item_class
	#EXM: make db_insert add_user_item

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class DB_Insert extends Console{

		public $class_prefix;
		public $file_prefix;

		public $inserts_folder;
		public $insert_file;

		public $insert_name;

		public $time;
		public $date;

		public $class_name;
		public $insert_data_to_replace;
		public $replace_classes = '';
		public $file_name;

		public $file_data;
		public $replaced_file_data;

		public function execute($insert_name){
			$this->inserts_folder = fx_path("system/migrations/inserts");

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

		public function getClassName(){
			$class_name = "{$this->class_prefix}_{$this->insert_name}_{$this->date}_{$this->time}";
			$class_name = fx_array_callback(explode("_",$class_name), function(&$key,&$value){
				$value = ucfirst($value);
			});
			$this->class_name = implode('',$class_name);
			return $this;
		}

		public function getFileName(){
			$insert_name = mb_strtolower($this->insert_name);
			$this->file_name = "{$this->date}_{$this->file_prefix}_{$insert_name}_{$this->time}";
			return $this;
		}

		public function getClassData(){
			$this->file_data = file_get_contents(fx_php_path("system/console/insertToDbClass.tmp"));
			return $this;
		}

		public function getReplacedData(){
			$this->replaced_file_data = str_replace(array(
				'__class_name__','/*insert data to replace*/','/*uses classes to replace*/'
			),array(
				$this->class_name,$this->insert_data_to_replace,$this->replace_classes,
			),$this->file_data);
			return $this;
		}

		public function setClassesToReplace(string $classes){
			$this->replace_classes = $classes;
			return $this;
		}

		public function setInsertDataToReplace($insert_data_to_replace){
			$this->insert_data_to_replace = $insert_data_to_replace;
			return $this;
		}

		public function getFilePath(){
			$this->insert_file = "{$this->inserts_folder}/{$this->file_name}.php";
			return $this;
		}

		public function saveNewClass(){
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


		public function errorMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.error_header'))->color('red')->print()->space();
				$print->string(fx_lang('cli.class_not_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->insert_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}

		public function alreadyMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.warning_header'))->color('yellow')->print()->space();
				$print->string(fx_lang('cli.class_already_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->insert_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}

		public function successfulMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.success_header'))->color('green')->print()->space();
				$print->string(fx_lang('cli.class_success_created',array(
					'%CLASS_NAME%'	=> $print->string("{$this->class_name}")->color('cyan')->get(),
					'%CLASS_FILE%'	=> $print->string("{$this->insert_file}")->color('white')->fon('blue')->get(),
				)))->print()->eol();
			});
			return $this;
		}
















	}














