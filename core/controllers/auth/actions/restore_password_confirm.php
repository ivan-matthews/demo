<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Kernel;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Restore_Password_Confirm as RestorePasswordForm;
	use Core\Classes\Form\Interfaces\Form as FormInterface;
	use Core\Classes\Mail\Mail;
	use Core\Classes\Mail\Session_Message;

	class Restore_Password_Confirm extends Controller{

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

		/** @var array */
		public $restore_password_token;
		public $restore_password_form;

		private $breadcrumb;

		public $user_data;
		public $fields_list;

		public $update_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->response->title('auth.title_restore_password_confirm');
			$this->breadcrumb = $this->response->breadcrumb('login')
				->setValue('auth.title_restore_password_confirm')
				->setIcon(null);
		}

		public function methodGet($restore_password_token){
			$this->restore_password_token = $restore_password_token;
			$this->breadcrumb->setLink('auth','restore_password_confirm',$this->restore_password_token);

			$this->user_data = $this->model->getUserByRestorePasswordToken($this->restore_password_token);
			if($this->user_data){
				$this->restore_password_form = RestorePasswordForm::getInstance();

				$this->restore_password_form->form(function(FormInterface $form){
					$form->setFormAction(fx_get_url('auth','restore_password_confirm',$this->restore_password_token));
				});

				$this->restore_password_form->generateFieldsList();

				if($this->params->actions['restore_password_confirm']['enable_captcha']){
					$this->restore_password_form->captcha();
				}

				$this->fields_list = $this->restore_password_form->getFieldsList();

				return $this->response->controller('auth','restore_password')
					->set('fields',$this->fields_list)
					->set('form',$this->restore_password_form->getFormAttributes())
					->set('errors',$this->restore_password_form->getErrors());
			}

			return false;
		}

		public function methodPost($restore_password_token){
			$this->restore_password_token = $restore_password_token;
			$this->breadcrumb->setLink('auth','restore_password_confirm',$this->restore_password_token);

			$this->user_data = $this->model->getUserByRestorePasswordToken($this->restore_password_token);
			if($this->user_data){
				$this->restore_password_form = RestorePasswordForm::getInstance();

				$this->restore_password_form->form(function(FormInterface $form){
					$form->setFormAction(fx_get_url('auth','restore_password_confirm',$this->restore_password_token));
				});

				$this->restore_password_form->checkFieldsList();
				$this->restore_password_form->checkPasswords();

				if($this->params->actions['restore_password_confirm']['enable_captcha']){
					$this->restore_password_form->captcha();
				}

				$this->fields_list = $this->restore_password_form->getFieldsList();

				if($this->restore_password_form->can()){
					$this->user_data['a_groups'] 		= $this->params->groups_after_verification;
					$this->user_data['a_verify_token'] 	= null;
					$this->user_data['a_date_activate'] = time();
					$this->user_data['a_status'] 		= Kernel::STATUS_ACTIVE;
					$this->user_data['a_password']		= fx_encode($this->fields_list['password']['attributes']['value']);
					$this->user_data['a_enc_password']	= fx_encryption($this->fields_list['password']['attributes']['value']);
					$this->user_data['a_bookmark']		= fx_encode($this->user_data['a_login'].$this->fields_list['password']['attributes']['value']);
					$this->user_data['a_restore_password_token']	= null;

					$this->update_data = $this->model->updateUserAuthDataByRestorePasswordToken($this->user_data);
					$this->user->escape();
					$this->user->auth($this->user_data,true);

					$this->sendRestorePasswordConfirmEmail($this->user_data);
					$this->sendRestorePasswordConfirmSessionMessage($this->user_data);

					return $this->redirect();
				}

				return $this->response->controller('auth','restore_password')
					->set('fields',$this->fields_list)
					->set('form',$this->restore_password_form->getFormAttributes())
					->set('errors',$this->restore_password_form->getErrors());
			}

			return false;
		}

		private function sendRestorePasswordConfirmEmail(array $input_data){
			Mail::set()
				->subject(fx_lang('auth.registration_mail_subject',array(
					'%site_name%'	=> $this->config->core['site_name']
				)))
				->to($input_data['a_login'])
				->html('restore_password_successful',array(
					'login'		=> $input_data['a_login'],
					'password'	=> fx_decryption($input_data['a_enc_password']),
					'bookmark'	=> $input_data['a_bookmark'],
					'id'		=> $input_data['u_id'],
				))
				->send();
			return $this;
		}

		private function sendRestorePasswordConfirmSessionMessage(array $input_data){
			Session_Message::set('restore_password')
				->head(fx_lang('auth.successful_restore_password_title'))
				->value(fx_lang('auth.successful_restore_password_value',array(
					'%user_email%'	=> $input_data['a_login']
				)))
				->disabled_pages('auth','resend_email')
				->send();
			return $this;
		}



















	}














