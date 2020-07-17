<?php

	namespace Core\Classes;

	class User{

		private static $instance;

		protected $user=array();

		private $groups;
		private $default_unauthorized_key = array(0);
		private $unauthorized;

		private $cookies;
		private $session;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->user[$key])){
				return $this->user[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->user[$name] = $value;
			return $this->user[$name];
		}

		public function __construct(){
			$this->session = Session::getInstance();
			$this->cookies = Cookie::getInstance();
			$this->config = Config::getInstance();
		}

		public function __destruct(){

		}

		public function getGroups(){
			$user_groups = $this->session->get('groups',Session::PREFIX_AUTH);
			if($user_groups){
				return $this->setLoggedGroups($user_groups);
			}
			return $this->setUnLoggedGroups();
		}

		public function setGroups(array $groups){
			$this->session->set('groups',$groups,Session::PREFIX_AUTH);
			return $this->getGroups();
		}

		private function setLoggedGroups($user_groups){
			$this->groups = array_combine(array_values($user_groups),array_values($user_groups));
			return $this->groups;
		}

		private function setUnLoggedGroups(){
			$this->unauthorized = true;
			$this->groups = $this->default_unauthorized_key;
			return $this->groups;
		}

		public function guest(){
			$this->getGroups();
			return $this->unauthorized;
		}

		public function logged(){
			$this->getGroups();
			return !$this->unauthorized;
		}

		public function validateAuthorize(){
			$auth_token = $this->session->get(Session::TOKEN_SESSION_KEY,Session::PREFIX_CONF);
			if($auth_token){
				if(!fx_equal(fx_encode($auth_token),$this->cookies->getCookie(Session::TOKEN_SESSION_KEY))){
					$this->session->cleanUserSession();
				}
			}
			return $this;
		}

		public function refreshAuthCookieTime(){
			if(!$this->session->get(Session::MEMBER_SESSION_KEY,Session::PREFIX_CONF)){
				return $this;
			}
			$cookie = $this->cookies->getCookie(Session::TOKEN_SESSION_KEY);
			if($cookie){
				$this->cookies->setCookie(Session::TOKEN_SESSION_KEY,$cookie,$this->config->session['session_time']);
			}
			return $this;
		}



















	}














