<?php

	namespace System\Cron_Tasks\Home;

	use Core\Classes\Config;
	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;

	class Remove_Old_Sessions{

		private $config;
		private $session_config;
		private $session_time;
		private $session_dir;

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->config = Config::getInstance();
			$this->session_config = $this->config->session;
			$this->session_time = $this->session_config['session_time'];
			$this->session_dir = fx_path($this->session_config['session_path']);

			$this->scanSessionDir();

			return true;
		}

		private function scanSessionDir(){
			$current_time = time();
			foreach(scandir($this->session_dir) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$time_last_access = filemtime("{$this->session_dir}/{$file}");
				if($time_last_access+$this->session_time > $current_time){ continue; }

				unlink("{$this->session_dir}/{$file}");

//				if(!file_exists("{$this->session_dir}/{$file}")){
//					$this->success($file,"{$this->session_dir}/{$file}");
//				}else{
//					$this->error($file,"{$this->session_dir}/{$file}");
//				}
			}
			return $this;
		}

		private function success($file,$path){
			return Paint::exec(function(Types $print)use($file,$path){
				$print->string('Session file ')->toPaint();
				$print->string($file)->fon('green')->toPaint();
				$print->string(' successful removed from ')->color('light_green')->toPaint();
				$print->eol()->tab();
				$print->string($path)->fon('blue')->toPaint();
				$print->eol();
			});
		}

		private function error($file,$path){
			return Paint::exec(function(Types $print)use($file,$path){
				$print->string('Session file ')->toPaint();
				$print->string($file)->fon('red')->toPaint();
				$print->string(' not removed from ')->color('light_red')->toPaint();
				$print->eol()->tab();
				$print->string($path)->fon('magenta')->toPaint();
				$print->eol();
			});
		}















	}














