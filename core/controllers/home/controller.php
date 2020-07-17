<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Controller as ParentController;
//	use Core\Controllers\Home\Config as Config;
//	use Core\Controllers\Home\Model as Model;

	class Controller extends ParentController{

		private static $instance;

		protected $controller_config;
		protected $controller_model;

		protected $home_controller;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->home_controller[$key])){
				return $this->home_controller[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->home_controller[$name] = $value;
			return $this->home_controller[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->controller_config = Config::getInstance();
			$this->controller_model = Model::getInstance();
		}

		public function __destruct(){

		}

















	}














