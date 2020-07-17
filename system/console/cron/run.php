<?php

	#CMD: cron run 
	#DSC: single run cron tasks command
	#EXM: cron run 

	namespace System\Console\Cron;

	use Core\Classes\Config;
	use Core\Classes\Database;
	use Core\Classes\Kernel;
	use Core\Console\Console;
	use Core\Console\Paint;
	use Core\Console\Interactive;
	use Core\Console\Interfaces\Types as PaintInterface;

	class Run extends Console{

		private $config;

		private $cron_tasks_array;
		private $locked_file;
		private $lock_to_write;
		private $cron_tasks_locked_files;

		private $update_data = array(
			'options'	=> null,
			'errors'	=> null,
			'result'	=> null,
			'date_updated'	=> null,
		);

		public function __construct(){
			parent::__construct();
			set_error_handler("Core\\Classes\\Error::nonSetError");
		}

		public function __destruct(){
			set_error_handler("Core\\Classes\\Error::getInstance");
		}

		public function execute(){
			$this->config = Config::getInstance();

			set_time_limit($this->config->cron['time_limit']);
			ignore_user_abort($this->config->cron['ignore_abort']);

			$this->cron_tasks_locked_files = fx_path($this->config->cron['cron_locked_files']);

			fx_make_dir($this->cron_tasks_locked_files,777);

			$this->getCronTasksArray();
			$this->startCronTasks();

			return $this->result;
		}

		private function getCronTasksArray(){
			$this->cron_tasks_array = Database::select('*')
				->from('cron_tasks')
				->where("`status`='" . Kernel::STATUS_ACTIVE . "'")
				->getArray();
			return $this;
		}

		private function startCronTasks(){
			if($this->cron_tasks_array){
				foreach($this->cron_tasks_array as $key=>$item){
					$this->cronTaskStarted($item);

					if(!$this->checkLastRun($item['date_updated']+$item['period'])){
						$this->skippedByTime();
						continue;
					}
					$this->lockFile($item['id']);
					$this->makeLockToWrite();
					if(!$this->checkLocked()){
						$this->skippedByFile();
						continue;
					}
					$this->shutDownFunction();
					$this->tryRunCronTask($item);

					$this->cron_tasks_array[$key]['date_updated'] = time();

					$this->updateCronTaskLastRun();
					$this->unlockFile($this->locked_file,$this->lock_to_write);
				}
				return $this;
			}
			return $this->nothingToExists();
		}

		private function tryRunCronTask($cron_task){
			$this->update_data['result'] = $cron_task['result'];
			$this->update_data['options'] = $cron_task['options'];
			$this->update_data['errors'] = $cron_task['errors'];
			$this->update_data['date_updated'] = time();

			try{

				$cron_task_object = new $cron_task['class']();
				call_user_func_array(array($cron_task_object,$cron_task['method']),$cron_task);
				$this->executeSuccessful();
			}catch(\Error $error){
				$this->update_data['errors']['message'] = $error->getMessage();
				$this->update_data['errors']['file'] = $error->getFile();
				$this->update_data['errors']['line'] = $error->getLine();
				$this->update_data['errors']['time'] = time();
				$this->executeError();
			}
			return $this;
		}

		private function updateCronTaskLastRun(){
			$update = Database::update('cron_tasks');
			foreach($this->update_data as $field => $value){
				$update->field($field,$value);
			}
			return $update->exec();
		}

		private function checkLastRun($last_run_time){
			if($last_run_time > time()){
				return false;
			}
			return true;
		}

		private function lockFile($file_lock){
			$this->locked_file = "{$this->cron_tasks_locked_files}/{$file_lock}";
			return $this;
		}

		private function makeLockToWrite(){
			$this->lock_to_write = @fopen($this->locked_file, 'w');
			return $this;
		}

		private function checkLocked(){
			if($this->lock_to_write && @flock($this->lock_to_write, LOCK_EX | LOCK_NB)){
				return true;
			}
			return false;
		}

		public function unlockFile($locked_file,$lock_to_write){
			if(is_file($locked_file)){
				@flock($lock_to_write, LOCK_UN);
				@unlink($locked_file);
			}
			return $this;
		}

		private function shutDownFunction(){
			register_shutdown_function(array($this,'unlockFile'),$this->locked_file,$this->lock_to_write);
			return $this;
		}

		private function cronTaskStarted($item){
			return Paint::exec(function(PaintInterface $print)use($item){
				$print->string('Cron task ')->toPaint();
				$print->string($item['title'])->fon('blue')->toPaint();
				$print->string(' > ')->toPaint();
			});
		}
		private function skippedByFile(){
			return Paint::exec(function(PaintInterface $print){
				$print->string('(lock file blocked)')->color('brown')->toPaint();
				$print->string(' ')->toPaint();
				$print->string('skipped!')->fon('magenta')->toPaint();
				$print->eol();
			});
		}
		private function skippedByTime(){
			return Paint::exec(function(PaintInterface $print){
				$print->string('(last run>current time)')->color('yellow')->toPaint();
				$print->string(' ')->toPaint();
				$print->string('skipped!')->fon('yellow')->toPaint();
				$print->eol();
			});
		}
		private function executeError(){
			return Paint::exec(function(PaintInterface $print){
				$print->string('(critical error)')->color('light_red')->toPaint();
				$print->string(' ')->toPaint();
				$print->string('error!')->fon('red')->toPaint();
				$print->eol();
			});
		}
		private function executeSuccessful(){
			return Paint::exec(function(PaintInterface $print){
				$print->string('successful exist!')->fon('green')->toPaint();
				$print->eol();
			});
		}

		private function nothingToExists(){
			return Paint::exec(function(PaintInterface $print){
				$print->string('Nothing to exists!')->fon('green')->toPaint();
				$print->eol();
			});
		}












	}