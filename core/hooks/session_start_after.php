<?php

	namespace Core\Hooks;

	use Core\Classes\User;

	class Session_Start_After{

		private $user;

		public function __construct(){
			$this->user = User::getInstance();
		}

		public function run(){
			$this->user->validateAuthorize();
			$this->user->refreshAuthCookieTime();
			$this->user->resetCSRFToken();
//			fx_pre('i\'m alive: ' . __METHOD__);
			return true;
		}

	}