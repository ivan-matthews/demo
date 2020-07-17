<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Model as ParentModel;

	class Model extends ParentModel{

		private static $instance;

		protected $home_model;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->home_model[$key])){
				return $this->home_model[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->home_model[$name] = $value;
			return $this->home_model[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function __destruct(){

		}



















	}














