<?php

	namespace Core\Classes;

	class Widgets{

		private static $instance;

		private $widgets=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->widgets[$key])){
				return $this->widgets[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->widgets[$name] = $value;
			return $this->widgets[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














