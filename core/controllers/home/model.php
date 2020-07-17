<?php

	namespace Core\Controllers\Home;

	use Core\Cache\Cache;
	use Core\Classes\Model as ParentModel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var array */
		private $home;

		/** @var Cache */
		protected $cache;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->home[$key])){
				return $this->home[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->home[$name] = $value;
			return $this->home[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->cache = $this->cache->key("home.index");
//			$this->cache = $this->cache->index(2);
			$this->cache = $this->cache->ttl(60);
		}

		public function __destruct(){

		}

		public function indexModel($data=array('asasa'=>'asa')){
			$cache = $this->cache->get();
			if(!$cache){
				return $this->cache->set($data);
			}
			return $cache;
		}

		public function secondModel($data=array('asasa'=>'asa')){
			$cache = $this->cache->get();
			if(!$cache){
				return $this->cache->set($data);
			}
			return $cache;
		}



















	}














