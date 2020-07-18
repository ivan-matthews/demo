<?php

	namespace Core\Controllers\Users;

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
		private $users;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->users[$key])){
				return $this->users[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->users[$name] = $value;
			return $this->users[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->setDefaultData();

			$this->params = Config::getInstance();	// use Core\Controllers\Users\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Users\Model as Model;

			$this->response->title('users.users_index_title');
			$this->response->breadcrumb('users')
				->setIcon(null)
				->setLink('users','index')
				->setValue('users.users_index_title');
		}

		public function __destruct(){

		}

















	}














