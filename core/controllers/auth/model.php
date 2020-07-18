<?php

	namespace Core\Controllers\Auth;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

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
		}

		public function getAuthDataByLogin($login){
			$this->cache->key('users.items');

			if(($widgets_list = $this->cache->get()->array())){
				return $widgets_list;
			}

			$widgets_list = $this->select()
				->from('auth')
				->join('users',"auth.id=users.auth_id")
				->where("`login`=%login%")
				->data('%login%',$login)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($widgets_list);
			return $widgets_list;
		}


















	}














