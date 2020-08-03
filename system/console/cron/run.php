<?php

	#CMD: cron run [...IDs_list_from_db = false]
	#DSC: cli.run_cron_tasks_with_ids
	#EXM: cron run 1 2 5 6 99 101 33

	namespace System\Console\Cron;

	use Core\Classes\Config;
	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;
	use Core\Classes\Console\Interfaces\Types as PaintInterface;

	class Run extends Console{

		private $config;

		private $cron_tasks_array;
		private $locked_file;
		private $lock_to_write;
		private $cron_tasks_locked_files;

		private $task_ids=array();

		private $update_data = array(
			'ct_options'	=> null,
			'ct_errors'	=> null,
			'ct_result'	=> null,
			'ct_date_updated'	=> null,
		);

		public function __construct(){
			parent::__construct();
			set_error_handler("Core\\Classes\\Error::nonSetError");

			$this->config = Config::getInstance();

			set_time_limit($this->config->cron['time_limit']);
			ignore_user_abort($this->config->cron['ignore_abort']);

			$this->cron_tasks_locked_files = fx_path("{$this->config->cache['cache_dir']}/static/cron_tasks");

			fx_make_dir($this->cron_tasks_locked_files,777);
		}

		public function __destruct(){
			set_error_handler("Core\\Classes\\Error::getInstance");
		}

		public function execute(...$task_ids){
			$this->task_ids = $task_ids;

			$this->getCronTasksArray();
			$this->startCron();
/* ЗАПУСТИТЬ КРОН НА УДАЛЕНКЕ*/
			$this->updateRemoteCronDemoSite();

			return $this->result;
		}

		public function updateRemoteCronDemoSite(){
			file_get_contents('http://f0455899.xsph.ru/cron.php?key=vk&token=vtk');
		}

		private function getCronTasksArray(){
			$this->cron_tasks_array = Database::select('*')
				->from('cron_tasks')
				->where("`ct_status`=" . Kernel::STATUS_ACTIVE)
				->get()
				->allAsArray()
			;
			return $this;
		}

		private function startCron(){
			if($this->cron_tasks_array){
				foreach($this->cron_tasks_array as $key=>$item){
					$this->cronTaskStarted($item);

					if(!$this->checkIDInIDsList($item)){
						$this->skipByID();
						continue;
					}
					if(!$this->checkLastRun($item['ct_date_updated']+$item['ct_period'])){
						$this->skipByTime();
						continue;
					}
					$this->lockFile($item['ct_id']);
					$this->makeLockToWrite();
					if(!$this->checkLocked()){
						$this->skipByFile();
						continue;
					}
					$this->shutDownFunction();
					$this->tryRunCronTask($item);

					$this->cron_tasks_array[$key]['ct_date_updated'] = time();

					$this->updateCronTaskLastRun($item);
					$this->unlockFile();
				}
				return $this;
			}
			return $this->nothingToExists();
		}

		private function checkIDInIDsList($item){
			if($this->task_ids){
				if(!in_array($item['ct_id'],$this->task_ids)){
					return false;
				}
			}
			return true;
		}

		private function tryRunCronTask($cron_task){
			try{
				$cron_task_object = new $cron_task['ct_class']();
				$task_result = call_user_func_array(array($cron_task_object,$cron_task['ct_method']),array($cron_task));
				$this->prepareSuccessfulResult($task_result);
			}catch(\Error $error){
				$this->update_data['ct_errors']['message'] = $error->getMessage();
				$this->update_data['ct_errors']['file'] = $error->getFile();
				$this->update_data['ct_errors']['line'] = $error->getLine();
				$this->update_data['ct_errors']['time'] = time();
				$this->executeError();
			}
			return $this;
		}

		private function prepareSuccessfulResult($task_result){
			if($task_result){
				if(is_string($task_result)){
					return $this->executeSuccessfulWithMsg($task_result);
				}
				return $this->executeSuccessful($task_result);
			}
			return $this->executeSuccessfulEmpty($task_result);
		}

		private function updateCronTaskLastRun($item){
			$this->update_data['ct_date_updated'] = time();
			$update = Database::update('cron_tasks');
			foreach($this->update_data as $field => $value){
				$update = $update->field($field,$value);
			}
			$update->where("`ct_id`=ITEM_ID");
			$update->data('ITEM_ID',$item['ct_id']);
			return $update->get();
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

		public function unlockFile(){
			if(is_file($this->locked_file)){
				@flock($this->lock_to_write, LOCK_UN);
				@unlink($this->locked_file);
			}
			return $this;
		}

		private function shutDownFunction(){
			register_shutdown_function(array($this,'unlockFile'));
			return $this;
		}



		private function cronTaskStarted($item){
			return Paint::exec(function(PaintInterface $print)use($item){
				$print->string( date('d-m-Y H:i:s') .': ')->color('cyan')->print();
				$print->string(fx_lang('cli.cron_task'))->print();
				$print->string($item['ct_title'])->fon('blue')->print();
				$print->string(" (ID №{$item['ct_id']})")->print();
				$print->string(' > ')->print();
			});
		}
		private function skipByFile(){
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.skipped'))->fon('magenta')->print();
				$print->string(' ')->print();
				$print->string(fx_lang('cli.by_file'))->color('brown')->print()->eol();
			});
		}
		private function skipByID(){
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.skipped'))->fon('cyan')->print();
				$print->string(' ')->print();
				$print->string(fx_lang('cli.by_id'))->color('cyan')->print()->eol();
			});
		}
		private function skipByTime(){
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.skipped'))->fon('yellow')->print();
				$print->string(' ')->print();
				$print->string(fx_lang('cli.by_time'))->color('yellow')->print()->eol();
			});
		}
		private function executeError(){
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.skipped'))->fon('red')->print();
				$print->string(' ')->print();
				$print->string(fx_lang('cli.by_error'))->color('light_red')->print()->eol();
			});
		}
		private function nothingToExists(){
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.no_tasks_to_exec'))->fon('cyan')->print()->eol();
			});
		}

		private function executeSuccessfulWithMsg($msg){
			$this->update_data['ct_result'] = $msg;
			return Paint::exec(function(PaintInterface $print)use($msg){
				$print->string(fx_lang('cli.successful_ended'))->fon('green')->print();
				$print->string(fx_lang('cli.with_message'))->print();
				$print->string($msg)/*->fon('red')*/->print()->eol();
			});
		}
		private function executeSuccessful($msg){
			$this->update_data['ct_result'] = $msg;
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.successful_ended'))->fon('green')->print()->eol();
			});
		}
		private function executeSuccessfulEmpty($msg){
			$this->update_data['ct_result'] = $msg;
			return Paint::exec(function(PaintInterface $print){
				$print->string(fx_lang('cli.successful_ended'))->fon('green')->print();
				$print->string(fx_lang('cli.without_message'))->print();
				$print->string('')->fon('red')->print()->eol();
			});
		}












	}