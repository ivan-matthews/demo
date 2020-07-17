<?php

	#CMD: cache clear 
	#DSC: cli.remove_cache
	#EXM: cache clear 

	namespace System\Console\Cache;

	use Core\Classes\Cache\Cache;
	use Core\Classes\Config;
	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Clear extends Console{

		private $config;
		private $cache_directory;
		private $cache_path;

		public function execute(){
			$this->config = Config::getInstance();

			$this->getCacheDirectory();
			$this->getCachePath();
			$this->deleteAllFindings();

			return $this->result;
		}

		private function getCacheDirectory(){
			$this->cache_directory = $this->config->cache['cache_dir'];
			return $this;
		}

		private function getCachePath(){
			$this->cache_path = fx_path($this->cache_directory);
			return $this;
		}

		private function deleteAllFindings(){
			Cache::getInstance()->clear();
			return Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.cache_cleared'))->fon('green')->toPaint();
				$print->eol();
			});
		}

















	}