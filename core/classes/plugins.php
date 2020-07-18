<?php

	namespace Core\Classes;

	class Plugins{

		private static $instance;

		private $plugins=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->plugins[$key])){
				return $this->plugins[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->plugins[$name] = $value;
			return $this->plugins[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














