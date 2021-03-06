<?php

	#CMD: cache clear 
	#DSC: cli.remove_cache
	#EXM: cache clear 

	namespace Core\Console\Cache;

	use Core\Classes\Cache\Cache;
	use Core\Classes\Config;
	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Clear extends Console{

		public $config;
		public $cache_directory;
		public $cache_path;

		public function execute(){
			$this->config = Config::getInstance();

			$this->getCacheDirectory();
			$this->getCachePath();
			$this->deleteAllFindings();

			return $this->result;
		}

		public function getCacheDirectory(){
			$this->cache_directory = $this->config->cache['cache_dir'];
			return $this;
		}

		public function getCachePath(){
			$this->cache_path = fx_path($this->cache_directory);
			return $this;
		}

		public function deleteAllFindings(){
			Cache::getInstance()->clear();
			return Paint::exec(function(Types $print){
				$print->string(fx_lang('cli.cache_cleared'))->fon('green')->print()->eol();
			});
		}

















	}