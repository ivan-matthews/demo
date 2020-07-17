<?php

	namespace __namespace__;

	class __class_name__{

		private static $instance;

		private $__property__=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->__property__[$key])){
				return $this->__property__[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->__property__[$name] = $value;
			return $this->__property__[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














