<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hook;
	use Core\Classes\Request;
	use Core\Classes\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

	class Item extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		protected $config;

		/** @var Model */
		protected $model;

		/** @var \Core\Classes\Config */
		protected $site_config;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

		/** @var \Core\Classes\User */
		protected $user;

		/** @var Hook */
		protected $hook;

		/** @var array */
		private $item;

		/** @return $this */
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














