<?php

	namespace Core\Classes;

	class Language{

		private static $instance;

		protected $language=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->language[$key])){
				return $this->language[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->language[$name] = $value;
			return $this->language[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














