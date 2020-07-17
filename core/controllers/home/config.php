<?php

	namespace Core\Controllers\Home;

	class Config{

		private static $instance;

		protected $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->config[$key])){
				return $this->config[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->config[$name] = $value;
			return $this->config[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














