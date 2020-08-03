<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\User;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Registration as RegistrationFrom;

	class Registration extends Controller{

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

		/** @var object */
		public $registration;
		
		public $fields_list;
		public $auth_data;
		public $user_data;
		public $user_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->registration = RegistrationFrom::getInstance('registration');

			$this->response->title('auth.title_registration_action');
			$this->response->breadcrumb('registration')
				->setValue('auth.title_registration_action')
				->setLink('auth','registration')
				->setIcon(null);
		}

		public function methodGet(){
			$this->registration->generateFieldsList();

			if($this->params->actions['registration']['enable_captcha']){
				$this->registration->setCaptcha();
			}

			$this->fields_list = $this->registration->getFieldsList();

			return $this->response->controller('auth','registration')
				->set('fields',$this->fields_list)
				->set('form',$this->registration->getFormAttributes())
				->set('errors',$this->registration->getErrors());
		}

		public function methodPost(){
			$this->registration->checkFieldsList();
			$this->registration->checkPasswords();
			$this->registration->checkLogin($this->model);

			if($this->params->actions['registration']['enable_captcha']){
				$this->registration->setCaptcha();
			}

			$this->fields_list = $this->registration->getFieldsList();

			if($this->registration->can()){
				$this->auth_data = array(
					'login'			=> $this->fields_list['login']['attributes']['value'],
					'password'		=> fx_encode($this->fields_list['password']['attributes']['value']),
					'enc_password'	=> fx_encryption($this->fields_list['password']['attributes']['value']),
					'groups'		=> $this->params->groups_after_registration,
					'bookmark'		=> fx_encode($this->fields_list['login']['attributes']['value'].$this->fields_list['password']['attributes']['value']),
					'verify_token'	=> $this->generateVerifyTokenKey(),
					'status'		=> Kernel::STATUS_LOCKED,
					'log_type'		=> User::LOGGED_DEFAULT,
					'date_created'	=> time(),
					'date_log'		=> time(),
				);
				$this->user_id = $this->model->addNewUser($this->auth_data);
				if($this->user_id){
					$this->user_data = $this->model->getAuthDataByUserId($this->user_id);
					$this->user_data['a_groups']	= fx_arr($this->user_data['a_groups']);

					$this->user->escape();
					$this->user->auth($this->user_data,true);

					return $this->redirect();
				}
			}

			return $this->response->controller('auth','registration')
				->set('fields',$this->fields_list)
				->set('form',$this->registration->getFormAttributes())
				->set('errors',$this->registration->getErrors());
		}

		public function generateVerifyTokenKey(){
			$login = $this->fields_list['login']['attributes']['value'];
			$password = $this->fields_list['password']['attributes']['value'];

			return trim(base64_encode(fx_encode($login . $login . $password . $password)),'=');
		}


















	}














