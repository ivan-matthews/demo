<?php

	#CMD: make class_file [Path/To/File]
	#DSC: create new standard php class file
	#EXM: make class_file Core/Classes/Database

	namespace System\Console\Make;

	use Core\Console\Console;
	use Core\Console\Paint;

	class Class_File extends Console{

		private $class;
		private $directory;
		private $namespace;
		private $lower_class_name;
		private $class_name;
		private $uc_first_class;
		private $class_data;
		private $replace_data;
		private $class_path;

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

		private function setClassName($class){
			$this->class = $class;
			return $this;
		}

		private function getNamespace(){
			$this->directory = dirname($this->class);
			$this->namespace = str_replace('/','\\',$this->directory);
			return $this;
		}

		private function getLowerClassName(){
			$this->lower_class_name = strtolower($this->class);
			return $this;
		}

		private function getBaseName(){
			$this->class_name = basename($this->lower_class_name);
			return $this;
		}

		private function getUcFirstClassName(){
			$this->uc_first_class = ucfirst($this->class_name);
			return $this;
		}

		private function getClassData(){
			$this->class_data = file_get_contents(fx_php_path("system/console/make/templates/mainClass.tmp"));
			return $this;
		}

		private function getReplacedData(){
			$this->replace_data = str_replace(array(
				'__namespace__','__property__','__class_name__'
			),array(
				$this->namespace,$this->class_name,$this->uc_first_class
			),$this->class_data);
			return $this;
		}

		private function saveNewClass(){
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

		private function errorMaking(){
			Paint::exec(function(Paint $print){
				$print->string('ERROR')->color('red')->toPaint();
				$print->string(': Class ')->toPaint();
				$print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$print->string(' not created in ')->toPaint();
				$print->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function alreadyMaking(){
			Paint::exec(function(Paint $print){
				$print->string('WARNING')->color('yellow')->toPaint();
				$print->string(': Class ')->toPaint();
				$print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$print->string(' already exists in ')->toPaint();
				$print->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function successfulMaking(){
			Paint::exec(function(Paint $print){
				$print->string('SUCCESS')->color('green')->toPaint();
				$print->string(': Class ')->toPaint();
				$print->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$print->string(' has been created in ')->toPaint();
				$print->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$print->eol();
			});
			return $this;
		}



















	}