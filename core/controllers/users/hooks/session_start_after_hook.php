<?php

	namespace Core\Controllers\Users\Hooks;

	use Core\Classes\Session;
	use Core\Classes\User;
	use Core\Controllers\Auth\Model;
	use Core\Classes\Config;

	class Session_Start_After_Hook{

		private $session;
		private $model;
		private $config;

		public function __construct(){
			$this->session = Session::getInstance();
			$this->model = Model::getInstance();
			$this->config = Config::getInstance();
		}

		public function run(){
			$user_id = $this->session->get('u_id',Session::PREFIX_AUTH);

			$current_time = time();
			$user_date_log = $this->session->get('u_date_log',Session::PREFIX_AUTH);
			$online_time = $this->config->session['online_time']+$current_time;

			if($user_id && $user_date_log<$current_time){
				$this->model->updateDateLog($user_id,$online_time,User::LOGGED_DEFAULT);
				$this->session->set('u_date_log',$online_time,Session::PREFIX_AUTH);
				$this->session->set('u_log_type',User::LOGGED_DEFAULT,Session::PREFIX_AUTH);
			}
			return true;
		}

	}