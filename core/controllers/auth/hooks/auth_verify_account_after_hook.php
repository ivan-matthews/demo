<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Verify_Account;
	use Core\Classes\Mail\Session_Message;

	class Auth_Verify_Account_After_Hook{

		private $verify_account_object;

		public function __construct(){
			$this->verify_account_object = Verify_Account::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->verify_account_object->user_data['status'],Kernel::STATUS_ACTIVE)){
				Session_Message::set('registration')
					->head(fx_lang('auth.email_verification_successful_title',array(
						'%user_full_name%'	=> $this->verify_account_object->user_data['full_name']
					)))
					->value(fx_lang('auth.email_verification_successful_body',array(
						'%mail_box%'	=> $this->verify_account_object->user_data['login']
					)))
					->send();
			}
			return $this;
		}
















	}