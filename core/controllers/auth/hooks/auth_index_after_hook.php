<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Index;

	class Auth_Index_After_Hook{

		private $user_login_action_object;

		public function __construct(){
			$this->user_login_action_object = Index::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->user_login_action_object->user_data['a_status'],Kernel::STATUS_LOCKED)){
				$this->user_login_action_object->sendRegisterSessionMessage(array(
					'login'	=> $this->user_login_action_object->user_data['a_login']
				));
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