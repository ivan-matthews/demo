<?php

	namespace Core\Hooks;

	use Core\Classes\User;

	class Load_System_After_Hook{

		private $user;

		public function __construct(){
			$this->user = User::getInstance();
		}

		public function run(){
			$this->user->setBackUrl();
			return true;
		}


















	}














