<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Resend_Email as ResendForm;

	class Resend_Email extends Controller{

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

		/** @var Session */
		public $session;

		/** @var Hooks */
		public $hook;

		/** @var object */
		public $resend_email;

		/** @var array */
		public $fields_list;

		public $login;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->resend_email = ResendForm::getInstance();

			$this->response->title('auth.title_resend_email');
			$this->response->breadcrumb('resend_email')
				->setValue('auth.title_resend_email')
				->setLink('auth','resend_email')
				->setIcon(null);
		}

		public function methodGet(){
			if(!fx_equal((int)$this->session->get('a_status',Session::PREFIX_AUTH),Kernel::STATUS_INACTIVE)){
				return $this->response->setResponseCode(403);
			}
			$this->resend_email->generateFieldsList();

			if($this->params->actions['resend_email']['enable_captcha']){
				$this->resend_email->setCaptcha();
			}

			$this->fields_list = $this->resend_email->getFieldsList();

			return $this->response->controller('auth','resend_email')
				->set('fields',$this->fields_list)
				->set('form',$this->resend_email->getFormAttributes())
				->set('errors',$this->resend_email->getErrors());
		}

		public function methodPost(){
			if(!fx_equal((int)$this->session->get('a_status',Session::PREFIX_AUTH),Kernel::STATUS_INACTIVE)){
				return $this->response->setResponseCode(403);
			}
			$this->resend_email->checkFieldsList();
			$this->resend_email->checkLogin($this->model);

			if($this->params->actions['resend_email']['enable_captcha']){
				$this->resend_email->setCaptcha();
			}

			$this->fields_list = $this->resend_email->getFieldsList();

			if($this->resend_email->can()){
				$this->login = $this->session->get('a_login',Session::PREFIX_AUTH);
				$this->sendRegisterEmail(array(
					'login'		=> $this->login,
					'password'	=>fx_decryption($this->session->get('a_enc_password',Session::PREFIX_AUTH)),
					'bookmark'	=> $this->session->get('a_bookmark',Session::PREFIX_AUTH),
					'token'		=> $this->session->get('a_verify_token',Session::PREFIX_AUTH),
					'id'		=> $this->session->get('u_id',Session::PREFIX_AUTH),
				));
				$this->sendRegisterSessionMessage(array(
					'login'	=> $this->login
				));

				return $this->response->controller('auth','resend_email_confirm')
					->set('email',$this->login);
			}

			return $this->response->controller('auth','resend_email')
				->set('fields',$this->fields_list)
				->set('form',$this->resend_email->getFormAttributes())
				->set('errors',$this->resend_email->getErrors());
		}



















	}














