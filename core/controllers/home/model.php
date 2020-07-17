<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Cache\Cache;
	use Core\Classes\Model as ParentModel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
//			$this->cache->ttl(5);
		}

		public function indexModel(){
			$this->cache->key('home.index');

			$result = $this->cache->get();
			if(!$result){
				$result = $this->select()->from('user_groups')->get()->itemAsArray();
				$this->cache->set($result);
			}
			return $result;
		}

















	}














