<?php

	namespace Core\Hooks;

	use Core\Classes\User;

	class Load_Script_After{

		private $user;

		public function __construct(){
			$this->user = User::getInstance();
		}

		public function run(){
			$this->user->setBackUrl();
//			fx_pre('i\'m alive: ' . __METHOD__);
			return true;
		}

	}