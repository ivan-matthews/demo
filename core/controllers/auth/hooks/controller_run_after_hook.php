<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Response\Response;
	use Core\Classes\Mail\Session_Message;

	class Controller_Run_After_Hook{

		private $response;
		private $response_code;

		public function __construct(){
			$this->response = Response::getInstance();
		}

		public function run(){
			$this->response_code = $this->response->getResponseCode();
			if(fx_equal($this->response_code,401)){
				$this->response->setResponseCode(302)
					->setHeader('location',fx_get_url('auth','index'));
				$this->setSessionMessage();
			}
			return true;
		}

		public function setSessionMessage(){
			Session_Message::set('user_un_authorize')
				->head(fx_lang('users.user_un_authorize_head'))
				->value(fx_lang('users.user_un_authorize_body'))
				->icon_class('far fa-meh-rolling-eyes')
				->expired_time(5)
				->send();
			return $this;
		}

	}