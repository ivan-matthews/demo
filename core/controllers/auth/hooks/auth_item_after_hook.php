<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Auth\Actions\Item;

	class Auth_Item_After_Hook{

		private $bookmark_object;

		public function __construct(){
			$this->bookmark_object = Item::getInstance();
		}

		public function run(){
			if(fx_equal((int)$this->bookmark_object->user_data['status'],Kernel::STATUS_LOCKED)){
				$this->bookmark_object->sendRegisterSessionMessage(array(
					'login'	=> $this->bookmark_object->user_data['login']
				));
				$this->bookmark_object->sendRegisterEmail(array(
					'login'		=> $this->bookmark_object->user_data['login'],
					'password'	=> fx_decryption($this->bookmark_object->user_data['enc_password']),
					'bookmark'	=> $this->bookmark_object->user_data['bookmark'],
					'token'		=> $this->bookmark_object->user_data['verify_token'],
					'id'		=> $this->bookmark_object->user_data['id'],
				));
			}
			return $this;
		}
















	}