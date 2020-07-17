<?php

	namespace System\Cron_Tasks\Home;

	use Core\Classes\Config;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class Remove_Old_Sessions{

		private $params;
		private $config;
		private $session_config;
		private $session_time;
		private $session_dir;
		private $result;

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->params = $params;
			$this->config = Config::getInstance();
			$this->session_config = $this->config->session;
			$this->session_time = $this->session_config['session_time'];
			$this->session_dir = fx_path($this->session_config['session_path']);

			$this->scanSessionDir();

			return PHP_EOL . $this->result;
		}

		private function scanSessionDir(){
			$current_time = time();
			foreach(scandir($this->session_dir) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$time_last_access = filemtime("{$this->session_dir}/{$file}");
				if($time_last_access+$this->session_time > $current_time){
					$this->skipped($file,"{$this->session_dir}/{$file}");
					continue;
				}
				unlink("{$this->session_dir}/{$file}");
				if(!file_exists("{$this->session_dir}/{$file}")){
					$this->success($file,"{$this->session_dir}/{$file}");
				}else{
					$this->error($file,"{$this->session_dir}/{$file}");
				}
			}
			return $this;
		}

		private function success($file,$path){
			return Paint::exec(function(Types $print)use($file,$path){
				$this->result .= $print->string(fx_lang('cli.session_file_has_removed',array(
					'CLASS_NAME' => $print->string($file)->fon('green')->get(),
					'FILE_NAME' => $print->string($path)->fon('blue')->get(),
				)) . PHP_EOL)->get();
			});
		}

		private function error($file,$path){
			return Paint::exec(function(Types $print)use($file,$path){
				$this->result .= $print->string(fx_lang('cli.session_file_not_removed',array(
					'CLASS_NAME' => $print->string($file)->fon('red')->get(),
					'FILE_NAME' => $print->string($path)->fon('light_red')->get(),
				)) . PHP_EOL)->get();
			});
		}

		private function skipped($file,$path){
			return Paint::exec(function(Types $print)use($file,$path){
				$this->result .= $print->string(fx_lang('cli.session_file_has_skipped',array(
					'CLASS_NAME' => $print->string($file)->fon('yellow')->get(),
					'FILE_NAME' => $print->string($path)->fon('magenta')->get(),
				)) . PHP_EOL)->get();
			});
		}















	}














