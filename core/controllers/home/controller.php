<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Controller as ParentController;

	class Controller extends ParentController{

		private static $instance;

		protected $config;
		protected $model;

		private $home;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->home[$key])){
				return $this->home[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->home[$name] = $value;
			return $this->home[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->config = Config::getInstance();
			$this->model = Model::getInstance();
		}

		public function __destruct(){

		}

















	}














