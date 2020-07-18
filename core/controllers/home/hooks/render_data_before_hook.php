<?php

	namespace Core\Controllers\Home\Hooks;

	use Core\Classes\Response\Response;
	use Core\Classes\Session;
	use Core\Classes\User;

	class Render_Data_Before_Hook{

		private $response;
		private $session;
		private $user;

		public function __construct(){
			$this->session = Session::getInstance();
			$this->response = Response::getInstance();
			$this->user = User::getInstance();
		}

		public function run(){
			$this->response->response_data['response_data']['session_messages'] = $this->session->getSessionMessages();
			$this->response->response_data['response_data']['link_to_redirect'] = $this->user->getBackUrl();
			return true;
		}

	}














