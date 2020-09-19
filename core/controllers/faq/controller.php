<?php

	namespace Core\Controllers\Faq;

	use Core\Classes\Access;
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
		private $faq;

		public $menu;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->faq[$key])){
				return $this->faq[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->faq[$name] = $value;
			return $this->faq[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Faq\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Faq\Model as Model;

			$this->setCategories('faq');
		}

		public function __destruct(){

		}

		public function setMenuLinks(){
			foreach($this->params->actions as $key=>$action){
				$access = new Access();
				$access->enableGroups($action['groups_enabled']);
				$access->disableGroups($action['groups_disabled']);
				if($access->granted()){
					$this->menu[$key] = true;
				}else{
					$this->menu[$key] = false;
				}
			}
			return $this;
		}

		public function setResponse(){
			$this->response->title('faq.faq_title_value');
			$this->response->breadcrumb('index')
				->setValue('faq.faq_title_value')
				->setLink('faq','index')
				->setIcon(null);
			return $this;
		}
















	}














