<?php

	namespace Core\Controllers\Avatar;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\Kernel;
	use Core\Classes\View;
	use Core\Classes\Session;

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

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Avatar\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Avatar\Model as Model;
		}

		public function __destruct(){

		}

		public function sessionUpdate($insert_data){
			$insert_data['p_date_updated'] = time();
			foreach($insert_data as $key=>$value){
				$this->session->set($key,$value,Session::PREFIX_AUTH);
			}
			return $this;
		}

		public function setResponse($avatar_data){
			$this->response->title('users.users_index_title');
			$this->response->breadcrumb('users')
				->setIcon(null)
				->setLink('users','index')
				->setValue('users.users_index_title');

			if(isset($avatar_data['u_id'])){
				$this->response->title($avatar_data['u_full_name']);
				$this->response->breadcrumb('user_item')
					->setValue($avatar_data['u_full_name'])
					->setLink('users','item',$avatar_data['u_id']);
			}

			return $this;
		}














	}














