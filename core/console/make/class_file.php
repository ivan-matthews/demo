<?php

	#CMD: make class_file [Path/To/File]
	#DSC: cli.standard_class_file
	#EXM: make class_file Core/Classes/Database

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interfaces\Types;

	class Class_File extends Console{

		public $class;
		public $directory;
		public $namespace;
		public $lower_class_name;
		public $class_name;
		public $uc_first_class;
		public $class_data;
		public $replace_data;
		public $class_path;

		public function execute($class){
			if(!$class){ return false; }
			$this
				->setClassName($class)
				->getNamespace()
				->getLowerClassName()
				->getBaseName()
				->getUcFirstClassName()
				->getClassData()
				->getReplacedData()
				->saveNewClass()
			;
			return $this->result;
		}

		public function setClassName($class){
			$this->class = $this->prepareClassName($class,'/');
			return $this;
		}

		public function getNamespace(){
			$this->directory = dirname($this->class);
			$this->namespace = str_replace('/','\\',$this->directory);
			return $this;
		}

		public function getLowerClassName(){
			$this->lower_class_name = strtolower($this->class);
			return $this;
		}

		public function getBaseName(){
			$this->class_name = basename($this->lower_class_name);
			return $this;
		}

		public function getUcFirstClassName(){
			$this->uc_first_class = $this->prepareClassName($this->class_name);
			return $this;
		}

		public function getClassData(){
			$this->class_data = file_get_contents(fx_php_path("system/console/mainClass.tmp"));
			return $this;
		}

		public function getReplacedData(){
			$this->replace_data = str_replace(array(
				'__namespace__','__property__','__class_name__'
			),array(
				$this->namespace,$this->class_name,$this->uc_first_class
			),$this->class_data);
			return $this;
		}

		public function saveNewClass(){
			fx_make_dir(fx_path(strtolower($this->directory)));
			$this->class_path = fx_php_path($this->lower_class_name);

			if(!file_exists($this->class_path)){
				$this->result = file_put_contents($this->class_path,$this->replace_data);
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
					'%CLASS_NAME%' => $print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->get(),
					'%CLASS_FILE%' => $print->string("{$this->class_path}")->color('white')->fon('blue')->get()
				)))->print()->eol();
			});
			return $this;
		}

		public function alreadyMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.warning_header'))->color('yellow')->print()->space();
				$print->string(fx_lang('cli.class_already_created',array(
					'%CLASS_NAME%' => $print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->get(),
					'%CLASS_FILE%' => $print->string($this->class_path)->color('white')->fon('blue')->get()
				)))->print()->eol();
			});
			return $this;
		}

		public function successfulMaking(){
			Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.success_header'))->color('green')->print()->space();
				$print->string(fx_lang('cli.class_success_created',array(
					'%CLASS_NAME%' => $print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->get(),
					'%CLASS_FILE%' => $print->string($this->class_path)->color('white')->fon('blue')->get()
				)))->print()->eol();
			});
			return $this;
		}



















	}