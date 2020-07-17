<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Config;

	class Cache{

		private static $instance;

		private $driver_key;
		private $params;
		private $config;
		/** @var Files */
		private $driver_object;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->params = $this->config->cache;
			$this->driver_key = $this->params['cache_driver'];
			$this->setCacheDriverObject();
		}

		public function get(){
			if(!$this->params['cache_enabled']){ return false; }
			return $this->driver_object->get();
		}
		public function set(array $data){
			return $this->driver_object->set($data);
		}
		public function clear(){
			return $this->driver_object->clear();
		}

		public function key($key){
			$this->driver_object->key($key);
			return $this;
		}
		public function index($index){
			$this->driver_object->index($index);
			return $this;
		}
		public function ttl($ttl){
			$this->driver_object->ttl($ttl);
			return $this;
		}

		private function setCacheDriverObject(){
			$class = "\\Core\\Classes\\Cache\\{$this->driver_key}";
			$this->driver_object = new $class($this->params);
			return $this;
		}

























	}














