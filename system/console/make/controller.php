<?php

	#CMD: make controller [controller_name], [...actions]
	#DSC: create new controller files
	#EXM: make controller users friends guests

	namespace System\Console\Make;

	use Core\Console\Console;
	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;

	class Controller extends Console{

		private $controller_name;
		private $controller_tmp_dir;
		private $controller_dir;
		private $actions;
		private $actions_tmp_file;
		private $actions_dir;

		private $__controller_namespace__;
		private $__controller_property__;
		private $__controller_dir__;

		public function execute($controller_name, ...$actions){
			$this->controller_name	= mb_strtolower($controller_name);
			$this->controller_tmp_dir = fx_path("system/console/make/templates/__controller_dir__");
			$this->controller_dir = fx_path("core/controllers/{$this->controller_name}");

			$this->__controller_namespace__ = $this->prepareClassName($this->controller_name);
			$this->__controller_property__ = $this->controller_name;
			$this->__controller_dir__ = $this->controller_name;

			$this->getControllerTmpFiles();

			if($actions){
				$this->actions = $actions;
				$this->actions_tmp_file = "{$this->controller_tmp_dir}/actions/index.php";
				$this->actions_dir = "{$this->controller_dir}/actions";
				$this->saveActions();
			}

			return $this->result;
		}

		private function saveActions(){
			$action_data = file_get_contents($this->actions_tmp_file);
			foreach($this->actions as $action){
				$action = strtolower($action);
				$action_class_name = $this->prepareClassName($action);
				$action_replaced_data = str_replace(array(
					'__controller_namespace__',
					'Index'
				),array(
					$this->__controller_namespace__,
					$action_class_name
				),$action_data);
				$this->saveData("{$this->actions_dir}/{$action}.php",$action_replaced_data);
			}
			return $this;
		}

		private function getControllerTmpFiles($scanned_path=null,$copied_path=null){
			if(!$scanned_path){
				$scanned_path = $this->controller_tmp_dir;
			}
			if(!$copied_path){
				$copied_path = $this->controller_dir;
			}

			$this->makeControllerDir($copied_path);

			foreach(scandir($scanned_path) as $file){
				if($file == '.' || $file == '..'){ continue; }

				$new_path = "{$scanned_path}/{$file}";
				$new_copied_path = "{$copied_path}/{$file}";

				if(is_dir($new_path)){
					$this->getControllerTmpFiles($new_path,$new_copied_path);
				}else{
					$file_data = file_get_contents($new_path);
					$file_replaced_data = $this->replaceData($file_data);
					$this->saveData($new_copied_path,$file_replaced_data);
				}
			}
			return $this;
		}

		private function replaceData($file_data){
			return str_replace(array(
				'__controller_namespace__',
				'__controller_property__',
				'__controller_dir__',
			),array(
				$this->__controller_namespace__,
				$this->__controller_property__,
				$this->__controller_dir__,
			),$file_data);
		}

		private function saveData($new_copied_path,$file_replaced_data){
			$file_name = ucfirst(basename($new_copied_path));
			if(!file_exists($new_copied_path)){
				if(file_put_contents($new_copied_path,$file_replaced_data)){
					$this->success('File',$file_name,$new_copied_path);
					return $this;
				}
			}
			$this->skipped('File',$file_name,$new_copied_path);
			return $this;
		}

		private function makeControllerDir($copied_path){
			$dir_name = ucfirst(basename($copied_path));
			if(fx_make_dir($copied_path)){
				$this->success("Directory",$dir_name,$copied_path);
			}else{
				$this->skipped("Directory",$dir_name,$copied_path);
			}
			return $this;
		}

		private function success($file_or_directory,$file_or_directory_name,$file_or_directory_path){
			return Paint::exec(function(Types $print)use($file_or_directory,$file_or_directory_name,$file_or_directory_path){
				$print->string("{$file_or_directory} \"")->toPaint();
				$print->string($file_or_directory_name)->color('light_green')->toPaint();
				$print->string("\" ")->toPaint();
				$print->string("successful created in ")->color('yellow')->toPaint();
				$print->string($file_or_directory_path)->color('light_cyan')->toPaint();
				$print->eol();
			});
		}

		private function skipped($file_or_directory,$file_or_directory_name,$file_or_directory_path){
			return Paint::exec(function(Types $print)use($file_or_directory,$file_or_directory_name,$file_or_directory_path){
				$print->string("{$file_or_directory} \"")->toPaint();
				$print->string($file_or_directory_name)->color('light_red')->toPaint();
				$print->string("\" ")->toPaint();
				$print->string("already exists in ")->color('light_purple')->toPaint();
				$print->string($file_or_directory_path)->color('light_cyan')->toPaint();
				$print->eol();
			});
		}















	}