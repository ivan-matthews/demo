<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Index;
	use Core\Classes\Mail\Session_Message;

	class Auth_Index_After_Hook{

		private $user_login_action_object;

		public function __construct(){
			$this->user_login_action_object = Index::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->user_login_action_object->user_data['a_status'],Kernel::STATUS_LOCKED)){
				Session_Message::set('registration')
					->head(fx_lang('auth.successful_registration_still_title'))
					->value(fx_lang('auth.successful_registration_value',array(
						'%user_email%'	=> $this->user_login_action_object->user_data['login'],
						'%resend_link%'	=> fx_get_url('auth','resend_email'),
					)))
					->icon_class('far fa-angry')
					->disabled_pages('auth','resend_email')
					->send();

				$this->user_login_action_object->sendRegisterEmail(array(
					'login'		=> $this->user_login_action_object->user_data['a_login'],
					'password'	=> fx_decryption($this->user_login_action_object->user_data['a_enc_password']),
					'bookmark'	=> $this->user_login_action_object->user_data['a_bookmark'],
					'token'		=> $this->user_login_action_object->user_data['a_verify_token'],
					'id'		=> $this->user_login_action_object->user_data['u_id'],
				));
			}
			return $this;
		}
















	}