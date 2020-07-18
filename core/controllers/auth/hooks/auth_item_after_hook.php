<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Item;
	use Core\Classes\Mail\Session_Message;

	class Auth_Item_After_Hook{

		private $bookmark_object;

		public function __construct(){
			$this->bookmark_object = Item::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->bookmark_object->user_data['a_status'],Kernel::STATUS_LOCKED)){
				Session_Message::set('registration')
					->head(fx_lang('auth.successful_registration_still_title'))
					->value(fx_lang('auth.successful_registration_value',array(
						'%user_email%'	=> $this->bookmark_object->user_data['a_login'],
						'%resend_link%'	=> fx_get_url('auth','resend_email'),
					)))
					->icon_class('far fa-angry')
					->disabled_pages('auth','resend_email')
					->send();

				$this->bookmark_object->sendRegisterEmail(array(
					'login'		=> $this->bookmark_object->user_data['a_login'],
					'password'	=> fx_decryption($this->bookmark_object->user_data['a_enc_password']),
					'bookmark'	=> $this->bookmark_object->user_data['a_bookmark'],
					'token'		=> $this->bookmark_object->user_data['a_verify_token'],
					'id'		=> $this->bookmark_object->user_data['u_id'],
				));
			}
			return $this;
		}
















	}