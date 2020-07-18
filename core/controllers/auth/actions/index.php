<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Auth_Form;

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

		/** @var array */
		public $index;

		public $auth_form;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->auth_form = Auth_Form::getInstance('auth');

			$this->response->title('auth.title_index_action');
			$this->response->breadcrumb('login')
				->setValue('auth.title_index_action')
				->setLink('auth')
				->setIcon(null);
		}

		public function methodGet(){
			return $this->response->controller('auth','index')
				->set('fields',$this->auth_form->generateFieldsList())
				->set('form',$this->auth_form->getFormAttributes())
				->set('errors',$this->auth_form->getErrors());
		}

		public function methodPost(){
			return $this->response->controller('auth','index')
				->set('fields',$this->auth_form->checkFieldsList())
				->set('form',$this->auth_form->getFormAttributes())
				->set('errors',$this->auth_form->getErrors());
		}




















	}














