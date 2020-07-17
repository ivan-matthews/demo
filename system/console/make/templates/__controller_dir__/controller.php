<?php

	namespace Core\Controllers\__controller_namespace__;

	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		protected $config;

		/** @var \Core\Classes\Model|Model */
		protected $model;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

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
			$this->config = Config::getInstance();	// use Core\Controllers\__controller_namespace__\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\__controller_namespace__\Model as Model;
		}

		public function __destruct(){

		}

















	}














