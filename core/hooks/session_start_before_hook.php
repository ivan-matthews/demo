<?php

	namespace Core\Hooks;

	use Core\Classes\Session;

	class Session_Start_Before_Hook{

		private $session;

		public function __construct(){
			$this->session = Session::getInstance();
		}

		public function run(){
			$this->session->checkSessionFile();
			return true;
		}

	}