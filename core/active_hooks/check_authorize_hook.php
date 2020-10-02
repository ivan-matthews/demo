<?php

	namespace Core\Active_Hooks;

	use Core\Classes\User;

	class Check_Authorize_Hook{

		private $user;

		public function __construct(){
			$this->user = User::getInstance();
		}

		public function run(){
			$this->user->validateAuthorize();
			$this->user->refreshAuthCookieTime();
			$this->user->resetCSRFToken();
			return true;
		}

	}