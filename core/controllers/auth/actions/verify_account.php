<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;

	class Verify_Account extends Controller{

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
		public $verify_token;

		public $user_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->dontSetBackLink();
		}

		public function methodGet($verify_token){
			$this->verify_token = $verify_token;

			$this->response->title('auth.title_auth_verify_account');
			$this->response->breadcrumb('verify_account')
				->setValue('auth.title_auth_verify_account')
				->setLink('auth','item',$this->verify_token)
				->setIcon(null);

			$this->user_data = $this->model->getUserByVerifyToken($this->verify_token);
			if($this->user_data){
				$this->user_data['groups'] = $this->config->groups_after_verification;
				$this->user_data['verify_token'] = null;
				$this->user_data['date_activate'] = time();
				$this->user_data['status'] = Kernel::STATUS_ACTIVE;

				$this->model->updateUserAuthDataByVerifyToken($this->user_data);

				$this->user->escape();
				$this->user->auth($this->user_data,true);

				return $this->redirect();
			}
			return false;
		}





















	}














