<?php

	namespace Core\Controllers\Comments;

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
		private $comments;

		public $controller;
		public $action = null;
		public $item_id;

		public $comments_list_id= "comment-list";
		public $limit_notices_author = 10;
		
		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->comments[$key])){
				return $this->comments[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->comments[$name] = $value;
			return $this->comments[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Comments\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Comments\Model as Model;
		}

		public function __destruct(){

		}

		public function checkAllowedController(){
			if(isset($this->params->allowed_controllers[$this->controller])){
				return true;
			}
			return null;
		}

















	}














