<?php

	namespace Core\Controllers\Messages;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

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
		private $messages;

		/** @var AttachmentsController */
		public $attachments_controller;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->messages[$key])){
				return $this->messages[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->messages[$name] = $value;
			return $this->messages[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Messages\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Messages\Model as Model;

			$this->attachments_controller = AttachmentsController::getInstance();
		}

		public function __destruct(){

		}

















	}














