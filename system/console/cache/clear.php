<?php

	#CMD: cache clear 
	#DSC: remove all cache files
	#EXM: cache clear 

	namespace System\Console\Cache;

	use Core\Classes\Config;
	use Core\Console\Console;
	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;
	use Core\Console\Interactive;

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
			fx_scandir_callback($this->cache_path,function($find){
				if(fx_equal(basename($find),'.htaccess')){ return true; }
				if(is_file($find)){
					unlink($find);
					Paint::exec(function(Types $print)use($find){
						$print->string("File: ")->color('brown')->toPaint();
						$print->string($find)->fon('green')->toPaint();
						$print->string(' successful removed!')->toPaint();
						$print->eol();
					});
					return true;
				}
				rmdir($find);
				Paint::exec(function(Types $print)use($find){
					$print->string("Folder: ")->color('brown')->toPaint();
					$print->string($find)->fon('green')->toPaint();
					$print->string(' successful removed!')->toPaint();
					$print->eol();
				});
				return true;
			});
			return Paint::exec(function(Types $print){
				$print->string("cache cleared successful!")->fon('green')->toPaint();
				$print->eol();
			});
		}

















	}