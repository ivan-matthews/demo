<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Controllers\Home\Controller;

	class Item extends Controller{

		private static $instance;

		private $item;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->item[$key])){
				return $this->item[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->item[$name] = $value;
			return $this->item[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->redirect();
		}

		public function __destruct(){

		}

		public function methodGet($id){
			return false;
		}

		public function methodPost($id){
			return false;
		}

		public function methodPut(){
			return false;
		}

		public function methodHead(){
			return false;
		}

		public function methodTrace(){
			return false;
		}

		public function methodPatch(){
			return false;
		}

		public function methodOptions(){
			return false;
		}

		public function methodConnect(){
			return false;
		}

		public function methodDelete(){
			return false;
		}




















	}














