<?php

	#CMD: make cron_task [controller, file]
	#DSC: make cron task file class and DB item
	#EXM: make cron_task users check_some_params

	namespace System\Console\Make;

	use Core\Console\Console;
	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;
	use Core\Console\Interactive;

	class Cron_Task extends Console{

		private $cron_tasks_path = 'system/cron_tasks';
		private $cron_task_file;

		private $controller;
		private $file;
		private $name_space;
		private $class_name;

		private $tmp_file;
		private $tmp_data;

		public function execute($controller, $file){
			$this->controller = strtolower($controller);
			$this->file	= strtolower($file);

			$this->name_space = $this->prepareClassName($this->controller);
			$this->class_name = $this->prepareClassName($this->file);

			$this->cron_tasks_path = fx_path($this->cron_tasks_path);
			$this->tmp_file = fx_path("system/console/make/templates/cronTaskClass.tmp.php");

			$this->cron_task_file = "{$this->cron_tasks_path}/{$this->controller}/{$this->file}.php";

			$this->makeTaskFolder();
			$this->getTmpData();
			$this->save();

			return $this->result;
		}

		private function getTmpData(){
			$this->tmp_data = file_get_contents($this->tmp_file);
			$this->tmp_data = str_replace(array(
				'__controller_namespace__',
				'__class_name__'
			),array(
				$this->name_space,
				$this->class_name
			),$this->tmp_data);
			return $this;
		}

		private function makeTaskFolder(){
			$cron_task_folder = "{$this->cron_tasks_path}/{$this->controller}";
			if(fx_make_dir($cron_task_folder)){
				Paint::exec(function(Types $print)use($cron_task_folder){
					$print->string('Folder ')->toPaint();
					$print->string($cron_task_folder)->fon('cyan')->toPaint();
					$print->string(' successful created!')->color('green')->toPaint();
					$print->eol();
				});
			}
			return $this;
		}

		private function saveTmpData(){
			file_put_contents($this->cron_task_file,$this->tmp_data);
			return $this;
		}

		private function save(){
			if(!file_exists($this->cron_task_file)){
				Paint::exec(function(Types $print){
					$print->string('Cron task class ')->toPaint();
					$print->string($this->class_name)->fon('blue')->toPaint();
					$print->string(' successful save to ')->toPaint();
					$print->string($this->cron_task_file)->fon('green')->toPaint();
					$print->eol();
				});
				$this->saveTmpData();
				$this->createDbInsertNewCronTask();
			}else{
				Paint::exec(function(Types $print){
					$print->string('Cron task class ')->toPaint();
					$print->string($this->class_name)->fon('blue')->toPaint();
					$print->string(' already exists in ')->toPaint();
					$print->string($this->cron_task_file)->fon('red')->toPaint();
					$print->eol();
				});
			}
			return $this;
		}

		private function createDbInsertNewCronTask(){
			$insert = new DB_Insert();

			$insert_data = "Database::insert('cron_tasks')\r\n";
			$insert_data .= "\t\t\t\t->value('title','{$this->controller} {$this->file}')\r\n";
			$insert_data .= "\t\t\t\t->value('description','cron task description')\r\n";
			$insert_data .= "\t\t\t\t->value('class',\"System\\\\Cron_Tasks\\\\{$this->name_space}\\\\{$this->class_name}\")\r\n";
			$insert_data .= "\t\t\t\t->value('method','execute')\r\n";
			$insert_data .= "\t\t\t\t->value('params',array())\r\n";
			$insert_data .= "\t\t\t\t->value('period',5)\t// seconds\r\n";
			$insert_data .= "\t\t\t\t->value('options',array())\r\n";
			$insert_data .= "\t\t\t\t->get();\r\n";
			$insert_data .= "\t\t\t".'return $this;';

			$insert->setInsertDataToReplace($insert_data);
			return $insert->execute("{$this->controller}_{$this->file}_cron_task");
		}














	}