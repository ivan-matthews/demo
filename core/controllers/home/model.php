<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

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
			$this->cache->ttl(5)->key('home.index.primary');
		}

		public function indexModel(){
			$this->cache->mark('simple.mark');
			$result = $this->cache->get()->object();

			if(!$result){
				$result = $this->select()
					->from('user_groups')
					->get()
					->itemAsObject();
				$this->cache->set($result);
			}
			return $result;
		}

		public function secondModel(){
			$this->cache->drop()->ttl(7)->key('home.index.secondary');
			$result = $this->cache->get()->array();

			if(!$result){
				$result = $this->select()
					->from('migrations')
					->get()
					->allAsArray();
				$this->cache->set($result);
			}
			return $result;
		}

















	}














