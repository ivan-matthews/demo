<?php

	#CMD: php cli make file [Path/To/File]
	#DSC: create new php class file
	#EXM: php cli make file Core/Classes/Database

	namespace System\Console\Make;

	use Core\Classes\Console;
	use Core\Classes\Paint;

	class File extends Console{

		protected $class;
		protected $directory;
		protected $namespace;
		protected $lower_class_name;
		protected $class_name;
		protected $uc_first_class;
		protected $class_data;
		protected $replace_data;
		protected $class_path;
		protected $result;

		public function execute($class){
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
			return $this;
		}

		protected function setClassName($class){
			$this->class = $class;
			return $this;
		}

		protected function getNamespace(){
			$this->directory = dirname($this->class);
			$this->namespace = str_replace('/','\\',$this->directory);
			return $this;
		}

		protected function getLowerClassName(){
			$this->lower_class_name = strtolower($this->class);
			return $this;
		}

		protected function getBaseName(){
			$this->class_name = basename($this->lower_class_name);
			return $this;
		}

		protected function getUcFirstClassName(){
			$this->uc_first_class = ucfirst($this->class_name);
			return $this;
		}

		protected function getClassData(){
			$this->class_data = file_get_contents(fx_php_path("system/console/make/templates/mainClass.tmp"));
			return $this;
		}

		protected function getReplacedData(){
			$this->replace_data = str_replace(array(
				'__namespace__','__property__','__class_name__'
			),array(
				$this->namespace,$this->class_name,$this->uc_first_class
			),$this->class_data);
			return $this;
		}

		protected function saveNewClass(){
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

		protected function errorMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('ERROR')->color('red')->toPaint();
				$paint->string(': Class ')->toPaint();
				$paint->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$paint->string(' not created in ')->toPaint();
				$paint->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}

		protected function alreadyMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('WARNING')->color('yellow')->toPaint();
				$paint->string(': Class ')->toPaint();
				$paint->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$paint->string(' already exists in ')->toPaint();
				$paint->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}

		protected function successfulMaking(){
			Paint::exec(function(Paint $paint){
				$paint->string('SUCCESS')->color('green')->toPaint();
				$paint->string(': Class ')->toPaint();
				$paint->string("{$this->namespace}\\{$this->uc_first_class}")->color('cyan')->toPaint();
				$paint->string(' has been created in ')->toPaint();
				$paint->string("{$this->class_path}")->color('white')->fon('blue')->toPaint();
				$paint->eol();
			});
			return $this;
		}



















	}