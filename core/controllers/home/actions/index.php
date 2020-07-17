<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Request;
	use Core\Classes\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

	class Index extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		protected $config;

		/** @var Model */
		protected $model;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

		/** @var array */
		private $index;

		/** @return $this */
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
			fx_pre(__METHOD__);
			return true;
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














