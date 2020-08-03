<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;

	class Item extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
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

		/** @var Session */
		public $session;

		/** @var array */
		public $item;

		public $user_id;
		public $avatar_id;
		public $avatar_data = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function methodGet($user_id,$avatar_id){
			$this->avatar_id = $avatar_id;
			$this->user_id = $user_id;

			$this->avatar_data = $this->model->getAvatarByID($this->avatar_id,$this->user_id);

			if($this->avatar_data){

				$this->setResponse($this->avatar_data)
					->appendResponse();

				$this->response->controller('avatar','item')
					->setArray(array(
						'avatar'	=> $this->avatar_data,
					));

				return $this;
			}

			return false;
		}

		public function appendResponse(){
			$this->response->title($this->avatar_data['p_name']);
			$this->response->breadcrumb('avatar_edit')
				->setValue($this->avatar_data['p_name'])
				->setLink('avatar','item',$this->user_id,$this->avatar_id);

			return $this;
		}



















	}














