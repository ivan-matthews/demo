<?php

	namespace Core\Active_Hooks;

	use Core\Classes\User;

	class Set_Back_URL_Hook{

		private $user;

		public function __construct(){
			$this->user = User::getInstance();
		}

		public function run(){
			$this->user->setBackUrl();
			return true;
		}


















	}














