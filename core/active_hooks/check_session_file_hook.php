<?php

	namespace Core\Active_Hooks;

	use Core\Classes\Session;

	class Check_Session_File_Hook{

		private $session;

		public function __construct(){
			$this->session = Session::getInstance();
		}

		public function run(){
			$this->session->checkSessionFile();
			return true;
		}

	}