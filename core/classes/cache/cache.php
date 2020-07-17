<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Config;

	class Cache{

		private static $instance;

		private $cache=array();

		private $config;
		private $cache_enabled;
		private $cache_driver;
		private $cache_ttl;

		/** @var Files */
		private $driver_object;

		public $cache_hash;
		public $backtrace;

		private $cache_key; // cache data address
		private $cache_hash_encoded;
		private $cache_hash_index=2;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->cache[$key])){
				return $this->cache[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->cache[$name] = $value;
			return $this->cache[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->cache_enabled = $this->config->cache['cache_enabled'];
			$this->cache_driver = $this->config->cache['cache_driver'];
			$this->cache_ttl = $this->config->cache['cache_ttl'];

			$this->driver_object = $this->getCacheObject();
			$this->driver_object->setCachePath($this->config->cache['cache_dir']);
			$this->driver_object->setCacheTTL($this->config->cache['cache_ttl']);
		}

		public function __destruct(){

		}

		public function index(int $index=2){
			$this->cache_hash_index = $index;
			return $this;
		}

		public function ttl($added_time){
			$this->driver_object->setCacheTTL($added_time);
			return $this;
		}

		public function key($cache_key){
			$this->cache_key = $this->driver_object->prepareKey($cache_key);
			return $this;
		}

		public function get(){
			if(!$this->cache_enabled){ return false; }
			$this->getCacheHash()->getCacheHashEncoded();
			return $this->driver_object->get($this->cache_key,$this->cache_hash_encoded);
		}

		public function set($cache_data){
			if(!$this->cache_enabled){ return false; }
			$this->getCacheHash()->getCacheHashEncoded();
			return $this->driver_object->set($cache_data,$this->cache_key,$this->cache_hash_encoded);
		}

		public function drop(){
			if(!$this->cache_enabled){ return false; }
			$this->getCacheHash()->getCacheHashEncoded();
			return $this->driver_object->drop($this->cache_key,$this->cache_hash_encoded);
		}

		private function getCacheObject(){
			if($this->driver_object){
				return $this->driver_object;
			}
			return $this->setCacheObject();
		}

		private function setCacheObject(){
			$class_name = "\\Core\\Classes\\Cache\\{$this->cache_driver}";
			return call_user_func(array($class_name,'getInstance'),$this);
		}

		private function getCacheHash(){
			$this->backtrace = debug_backtrace();
			if(isset($this->backtrace[$this->cache_hash_index])){
				$dbg_arr = $this->backtrace[$this->cache_hash_index];
				$this->cache_hash = isset($dbg_arr['class']) ? $dbg_arr['class'] : false;
				$this->cache_hash .= isset($dbg_arr['type']) ? $dbg_arr['type'] : false;
				$this->cache_hash .= isset($dbg_arr['function']) ? $dbg_arr['function'] : false;
				$this->cache_hash .= isset($dbg_arr['args']) ? '('.fx_implode(',',$dbg_arr['args']).')' : '()';
			}
			return $this;
		}

		private function getCacheHashEncoded(){
			$this->cache_hash_encoded = md5($this->cache_key . $this->cache_hash);
			return $this;
		}
















	}














