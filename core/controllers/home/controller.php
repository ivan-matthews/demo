<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Controller as ParentController;
	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $config;

		/** @var \Core\Classes\Model|Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $site_config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $home;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->home[$key])){
				return $this->home[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->home[$name] = $value;
			return $this->home[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->config = Config::getInstance();
			$this->model = Model::getInstance();

			$this->response->title(fx_lang('home.title_home_page'));
			$this->response->breadcrumb('home')
				->setValue(fx_lang('home.breadcrumb_home_page'))
				->setLink(fx_get_url('home'))
				->setIcon(null);
		}

		public function __destruct(){

		}

















	}














