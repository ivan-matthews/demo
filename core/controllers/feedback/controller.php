<?php

	namespace Core\Controllers\Feedback;

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
		private $feedback;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->feedback[$key])){
				return $this->feedback[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->feedback[$name] = $value;
			return $this->feedback[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Feedback\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Feedback\Model as Model;
		}

		public function __destruct(){

		}

		public function setResponse(){
			$this->response->title('feedback.index_action_title');
			$this->response->breadcrumb('index')
				->setValue('feedback.index_action_title')
				->setIcon(null)
				->setLink('feedback','index');
			return $this;
		}
















	}














