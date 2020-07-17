<?php

	namespace Core\Controllers\__controller_namespace__\Actions;

	use Core\Classes\Response;
	use Core\Classes\Router;
	use Core\Classes\Request;

	use Core\Controllers\__controller_namespace__\Controller;

	class Index extends Controller{

		private static $instance;

		protected $index;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->index[$key])){
				return $this->index[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->index[$name] = $value;
			return $this->index[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function __destruct(){

		}

		public function methodGet(){
			fx_pre(__METHOD__);
			return true;
		}

		public function methodPost(){
			fx_pre(__METHOD__);
			return true;
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














