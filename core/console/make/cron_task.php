<?php

	#CMD: make cron_task [...cron_task_params]
	#DSC: cli.new_cron_task
	#EXM: make cron_task home some_cron_action

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Cron_Task extends Console{

		private $cron_tasks_path = 'core/controllers';
		private $cron_task_dir;
		private $cron_task_file;

		private $controller;
		private $file;
		private $params=array();
		private $name_space;
		private $class_name;

		private $tmp_file;
		private $tmp_data;

		public function execute(...$cron_task_params){
			if(!isset($cron_task_params[0]) || !isset($cron_task_params[1])){ return false; }

			$file = $cron_task_params[1];
			$controller = $cron_task_params[0];
			$params = array_slice($cron_task_params,2) ?? array();

			$this->controller = strtolower($controller);
			$this->file	= strtolower($file);
			$this->params = $params;

			$this->name_space = $this->prepareClassName($this->controller);
			$this->class_name = $this->prepareClassName($this->file);

			$this->cron_tasks_path = fx_path($this->cron_tasks_path);
			$this->tmp_file = fx_path("system/console/cronTaskClass.tmp.php");

			$this->cron_task_dir = "{$this->cron_tasks_path}/{$this->controller}/cron";
			fx_make_dir($this->cron_task_dir);

			$this->cron_task_file = "{$this->cron_task_dir}/{$this->file}.php";

			$this->makeTaskFolder();
			$this->getTmpData();
			$this->save();

			return $this->result;
		}

		private function getTmpData(){
			$this->tmp_data = file_get_contents($this->tmp_file);
			$this->tmp_data = str_replace(array(
				'__controller_namespace__',
				'__class_name__',
			),array(
				$this->name_space,
				$this->class_name,
			),$this->tmp_data);
			return $this;
		}

		private function makeTaskFolder(){
			$cron_task_folder = "{$this->cron_tasks_path}/{$this->controller}";
			if(fx_make_dir($cron_task_folder)){
				Paint::exec(function(Types $print)use($cron_task_folder){
					$print->string(fx_lang('cli.folder_making',array(
						'%FOLDER%'	=> $print->string($cron_task_folder)->fon('cyan')->get(),
					)))->print()->eol();
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
					$print->string(fx_lang('cli.cron_task_making',array(
						'%CLASS_NAME%' => $print->string($this->class_name)->fon('blue')->get(),
						'%CLASS_FILE%' => $print->string($this->cron_task_file)->fon('green')->get(),
					)))->print()->eol();
				});
				$this->saveTmpData();
				$this->createDbInsertNewCronTask();
			}else{
				Paint::exec(function(Types $print){
					$print->string(fx_lang('cli.cron_task_not_making',array(
						'%CLASS_NAME%' => $print->string($this->class_name)->fon('blue')->get(),
						'%CLASS_FILE%' => $print->string($this->cron_task_file)->fon('red')->get(),
					)))->print()->eol();
				});
			}
			return $this;
		}

		private function createDbInsertNewCronTask(){
			$insert = new DB_Insert();

			$insert_data = "Database::insert('cron_tasks')\r\n";
			$insert_data .= "\t\t\t\t->value('ct_title','{$this->controller} {$this->file}')\r\n";
			$insert_data .= "\t\t\t\t->value('ct_description','{$this->controller} {$this->file} cron task action')\r\n";
			$insert_data .= "\t\t\t\t->value('ct_class',{$this->class_name}::class)\r\n";
			$insert_data .= "\t\t\t\t->value('ct_method','execute')\r\n";
			$insert_data .= "\t\t\t\t->value('ct_params',array())\r\n";
			$insert_data .= "\t\t\t\t->value('ct_period',5)\t// seconds\r\n";
			$insert_data .= "\t\t\t\t->value('ct_options',array())\r\n";
			$insert_data .= "\t\t\t\t->get();\r\n";
			$insert_data .= "\t\t\t".'return $this;';

			$insert->setInsertDataToReplace($insert_data);
			$insert->setClassesToReplace("\r\n\tuse Core\\Controllers\\{$this->name_space}\\Cron\\{$this->class_name};");
			return $insert->execute("cron_task_{$this->controller}_{$this->file}");
		}














	}