<?php

	namespace Core\Cache;

	use Core\Classes\Kernel;
	use Core\Classes\Response;

	class Files{

		const CACHE_TTL_KEY = 'cache_time_expired';

		private static $instance;

		protected $files=array();

		private $cache;
		private $cache_path;
		private $cache_key_path;
		private $cache_dir;
		private $cache_file;
		private $cache_ttl;
		private $current_time;

		public static function getInstance(Cache $called_object){
			if(self::$instance === null){
				self::$instance = new self($called_object);
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->files[$key])){
				return $this->files[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->files[$name] = $value;
			return $this->files[$name];
		}

		public function __construct(Cache $called_object){
			$this->current_time = time();
			$this->cache = $called_object;
		}

		public function __destruct(){

		}

		public function get($key,$hash){
			$time = microtime(true);
			$this->setCacheFile($key,$hash);
			if(is_readable($this->cache_file)){
				$cache_data = $this->tryImportCacheFile();
				if($cache_data){
					if($this->checkExpiredTime($cache_data[self::CACHE_TTL_KEY])){
						unset($cache_data[self::CACHE_TTL_KEY]);
						Response::debug('cache')
							->index(2)
							->set('result',$this->cache_file)
							->setTime($time)
							->setQuery($this->cache->cache_hash)
							->setTrace($this->cache->backtrace);
						return $cache_data;
					}
				}
				$this->dropCacheFile();
			}
			return false;
		}

		public function set($data,$key,$hash){
			$this->setCacheFile($key,$hash);
			$this->makeCacheDir();
			if($data && is_array($data)){
				$data[self::CACHE_TTL_KEY] = $this->current_time + $this->cache_ttl;
				return file_put_contents($this->cache_file,fx_php_encode($data));
			}
			return false;
		}

		public function drop($key,$hash){
			$this->setCacheFile($key,$hash);
			return $this->dropCacheFile();
		}

		public function setCachePath($cache_dir){
			$this->cache_dir = $cache_dir;
			$this->setCacheDir();
			return $this;
		}
		public function setCacheTTL($cache_ttl){
			$this->cache_ttl = $cache_ttl;
			return $this;
		}
		public function prepareKey($key){
			return str_replace('.',DIRECTORY_SEPARATOR,$key);
		}

		private function tryImportCacheFile(){
			$cache_data = null;
			try{
				$cache_data = fx_import_file($this->cache_file,Kernel::IMPORT_INCLUDE);
			}catch(\Error $e){
				return false;
			}
			return $cache_data;
		}

		private function checkExpiredTime($expired_time){
			if($this->current_time < $expired_time){
				return true;
			}
			return false;
		}

		private function dropCacheFile(){
			return unlink($this->cache_file);
		}

		private function setCacheDir(){
			$this->cache_path = fx_path($this->cache_dir);
			return $this;
		}

		private function setCacheFile($cache_key_path,$cache_encoded_hash){
			$this->cache_key_path = "{$this->cache_path}/{$cache_key_path}";
			$this->cache_file = "{$this->cache_key_path}/{$cache_encoded_hash}.php";
			return $this;
		}

		private function makeCacheDir(){
			fx_make_dir($this->cache_key_path,0777);
			return $this;
		}













	}














