<?php

	namespace Core\Hooks;

	use Core\Classes\Session;
	use Core\Classes\Mail\Session_Message;

	class Render_Data_Before_Hook{

		private $session;

		public function __construct(){
			$this->session = Session::getInstance();
		}

		public function run(){
			if($this->session->new_user){
				Session_Message::set('new_user')
					->head(fx_lang('users.new_user_sess_msg_head'))
					->value(fx_lang('users.new_user_sess_msg_body'))
					->send();
			}
			return $this;
		}

	}














