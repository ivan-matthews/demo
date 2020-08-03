<?php

	namespace Core\Controllers\__controller_namespace__;

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
		private $__controller_property__;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->__controller_property__[$key])){
				return $this->__controller_property__[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->__controller_property__[$name] = $value;
			return $this->__controller_property__[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\__controller_namespace__\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\__controller_namespace__\Model as Model;
		}

		public function __destruct(){

		}

















	}














