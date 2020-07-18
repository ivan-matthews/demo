<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Registration;

	class Auth_Registration_After_Hook{

		private $registration_object;

		public function __construct(){
			$this->registration_object = Registration::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->registration_object->user_data['a_status'],Kernel::STATUS_LOCKED)){
				$this->registration_object->sendRegisterSessionMessage(array(
					'login'	=> $this->registration_object->user_data['a_login']
				));
				$this->registration_object->sendRegisterEmail(array(
					'login'		=> $this->registration_object->user_data['a_login'],
					'password'	=> fx_decryption($this->registration_object->user_data['a_enc_password']),
					'bookmark'	=> $this->registration_object->user_data['a_bookmark'],
					'token'		=> $this->registration_object->user_data['a_verify_token'],
					'id'		=> $this->registration_object->user_data['u_id'],
				));
			}
			return $this;
		}
















	}