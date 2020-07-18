<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;

	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

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

		/** @var Hooks */
		public $hook;

		public $called_class_object;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->response->title('home.title_index_page');
			$this->response->breadcrumb('index')
				->setValue('home.breadcrumb_index_page')
				->setLink('home','index')
				->setIcon(null);
		}

		public function methodGet(){

			if($this->config->just_widgets){ return true; }

			if(class_exists($this->config->another_controller['class'])){
				$this->called_class_object = call_user_func(array($this->config->another_controller['class'],'getInstance'));
				return call_user_func_array(array(
					$this->called_class_object, $this->config->another_controller['method']
				),array($this->config->another_controller['params']));
			}

			return true;
		}




















	}














