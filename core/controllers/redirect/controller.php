<?php

	namespace Core\Controllers\Redirect;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var \Core\Classes\Model|Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $redirect;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->redirect[$key])){
				return $this->redirect[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->redirect[$name] = $value;
			return $this->redirect[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Redirect\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Redirect\Model as Model;
		}

		public function __destruct(){

		}

















	}














