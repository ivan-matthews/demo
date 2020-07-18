<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Mail\Mail;
	use Core\Classes\Mail\Session_Message;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Restore_Password as RestorePasswordForm;

	class Restore_Password extends Controller{

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

		public $restore_password_form;
		public $restore_password;
		public $fields_list;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->restore_password_form = RestorePasswordForm::getInstance();

			$this->response->title('auth.title_restore_password');
			$this->response->breadcrumb('restore_password')
				->setValue('auth.title_restore_password')
				->setLink('auth','restore_password')
				->setIcon(null);
		}

		public function methodGet(){
			$this->restore_password_form->generateFieldsList();

			if($this->params->actions['restore_password']['enable_captcha']){
				$this->restore_password_form->setCaptcha();
			}

			$this->fields_list = $this->restore_password_form->getFieldsList();

			return $this->response->controller('auth','restore_password')
				->set('fields',$this->fields_list)
				->set('form',$this->restore_password_form->getFormAttributes())
				->set('errors',$this->restore_password_form->getErrors());
		}

		public function methodPost(){
			$this->restore_password_form->checkFieldsList();
			$this->restore_password_form->checkLogin($this->model);

			if($this->params->actions['restore_password']['enable_captcha']){
				$this->restore_password_form->setCaptcha();
			}

			$this->fields_list = $this->restore_password_form->getFieldsList();

			if($this->restore_password_form->can()){

				$this->restore_password = $this->model->generateRestorePasswordToken();

				$this->model->updateUserRestorePasswordToken(array(
					'restore_password_token'	=> $this->restore_password,
					'date_password_restore'		=> time(),
				),$this->fields_list['login']['attributes']['value']);

				Mail::set()
					->subject(fx_lang('auth.title_restore_password'))
					->to($this->fields_list['login']['attributes']['value'])
					->html('restore_password',array(
						'restore_password_token'	=> $this->restore_password
					))
					->send();

				Session_Message::set('restore_password')
					->head(fx_lang('auth.title_restore_password'))
					->value(fx_lang('auth.restore_password_mail_send_successful',array(
						'%email%'	=> $this->fields_list['login']['attributes']['value']
					)))
					->disabled_pages('auth','restore_password','restore_password_confirm')
					->send();

				return $this->redirect();
			}

			return $this->response->controller('auth','restore_password')
				->set('fields',$this->fields_list)
				->set('form',$this->restore_password_form->getFormAttributes())
				->set('errors',$this->restore_password_form->getErrors());
		}



















	}














