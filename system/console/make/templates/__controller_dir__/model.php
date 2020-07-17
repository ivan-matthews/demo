<?php

	namespace Core\Controllers\__controller_namespace__;

	use Core\Cache\Cache;
	use Core\Classes\Model as ParentModel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var array */
		private $__controller_property__;

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
			if(isset($this->__controller_property__[$key])){
				return $this->__controller_property__[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->__controller_property__[$name] = $value;
			return $this->__controller_property__[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function __destruct(){

		}



















	}














