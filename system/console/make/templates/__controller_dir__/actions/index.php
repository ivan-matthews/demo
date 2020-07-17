<?php

	namespace Core\Controllers\__controller_namespace__\Actions;

	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\__controller_namespace__\Config;
	use Core\Controllers\__controller_namespace__\Controller;
	use Core\Controllers\__controller_namespace__\Model;

	class Index extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $config;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $site_config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var array */
		private $__action_property__;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->__action_property__[$key])){
				return $this->__action_property__[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->__action_property__[$name] = $value;
			return $this->__action_property__[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function __destruct(){

		}

		public function methodGet(){
			return false;
		}

		public function methodPost(){
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














