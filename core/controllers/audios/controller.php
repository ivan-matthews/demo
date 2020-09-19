<?php

	namespace Core\Controllers\Audios;

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
		private $audios;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->audios[$key])){
				return $this->audios[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->audios[$name] = $value;
			return $this->audios[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Audios\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Audios\Model as Model;
		}

		public function __destruct(){

		}

		public function setResponse(){
			$this->response->title('audios.audios_index_title');
			$this->response->breadcrumb('index')
				->setIcon(null)
				->setLink('audios','index')
				->setValue('audios.audios_index_title');

			return $this;
		}
















	}














