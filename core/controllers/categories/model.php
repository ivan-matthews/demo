<?php

	namespace Core\Controllers\Categories;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		private $result;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('categories');
		}

		public function __destruct(){

		}

		public function getCategoriesByCurrentController($controller){
			$result = $this->select()
				->from('categories')
				->where("`ct_controller`=%controller%")
				->data('%controller%',$controller)
				->order('ct_order')
				->sort('ASC')
				->get()
				->allAsArray();

			return $result;
		}



















	}














