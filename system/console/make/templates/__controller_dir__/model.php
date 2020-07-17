<?php

	namespace Core\Controllers\__controller_namespace__;

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
			$this->cache->key('__controller_namespace__');
//			$this->cache->ttl(5);
		}

		public function __destruct(){

		}



















	}














