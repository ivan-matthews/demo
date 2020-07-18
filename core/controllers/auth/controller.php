<?php

	namespace Core\Controllers\Auth;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\Mail\Mail;
	use Core\Classes\Mail\Session_Message;

	/**
	 * Class Controller
	 * @package Core\Controllers\Auth
	 * @action index 						login				+
	 * @action item 						bookmark			+
	 * @action logout 						exit				+
	 * @action registration 				registration		+
	 * @action resend_email 				resend email		+
	 * @action restore_password 			restore password
	 * @action restore_password_confirm		new password insert form after verify_token successful confirmed
	 * @action verify_account 				check verify_token	+
	 * @action change_email 				check verify_token	???
	 */
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

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->config = Config::getInstance();	// use Core\Controllers\Auth\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Auth\Model as Model;

			$this->response->title('auth.title_auth_controller');
			$this->response->breadcrumb('auth')
				->setValue('auth.title_auth_controller')
				->setLink('auth')
				->setIcon(null);
		}

		public function sendRegisterEmail(array $input_data){
			Mail::set()
				->subject(fx_lang('auth.registration_mail_subject',array(
					'%site_name%'	=> $this->site_config->core['site_name']
				)))
				->to($input_data['login'])
				->html('registration_successful',array(
					'login'		=> $input_data['login'],
					'password'	=> $input_data['password'],
					'bookmark'	=> $input_data['bookmark'],
					'token'		=> $input_data['token'],
					'id'		=> $input_data['id'],
				))
				->send();
			return $this;
		}

		public function sendRegisterSessionMessage(array $input_data){
			Session_Message::set('registration')
				->head(fx_lang('auth.successful_registration_title'))
				->value(fx_lang('auth.successful_registration_value',array(
					'%user_email%'	=> $input_data['login'],
					'%resend_link%'	=> fx_get_url('auth','resend_email'),
				)))
				->disabled_pages('auth','resend_email')
				->send();
			return $this;
		}

















	}














