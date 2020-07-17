<?php

	namespace Core\Controllers\__controller_namespace__;

	use Core\Classes\Model as ParentModel;

	class Model extends ParentModel{

		private static $instance;

		private $__controller_property__;

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














