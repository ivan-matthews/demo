<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;
	use Core\Controllers\Users\Forms\Item as UserForm;

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
		public $user_data;
		public $user_id;

		public $users_item_form;
		public $fields;
		public $fields_list;
		public $user_menu = array();

		private $breadcrumbs;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->breadcrumbs = $this->response->breadcrumb('users_item')
				->setIcon(null);
			$this->users_item_form = UserForm::getInstance();
		}

		public function methodGet($user_id){
			$this->user_id = $user_id;

			$this->user_data = $this->model->getUserByID($user_id);
			if($this->user_data){

				$this->response->title($this->user_data['u_full_name']);
				$this->breadcrumbs->setLink('users','item',$this->user_data['u_id'])
					->setValue($this->user_data['u_full_name']);

				$this->fields = $this->params->getParams('fields');

				$this->fields_list = $this->users_item_form->getFields($this->fields);

				$this->response->controller('users','item')
					->setArray(array(
						'user'	=> $this->user_data,
						'fields'=> $this->fields_list,
						'menu'	=> $this->user_menu,
					));
				return $this;
			}
			return $this->renderEmptyPage();
		}

















	}














