<?php

	namespace Core\Classes;

	use Core\Classes\Response\Response;

	class User{

		const LOGGED_APPLE 		= 1;
		const LOGGED_ANDROID 	= 2;
		const LOGGED_LINUX 		= 3;
		const LOGGED_WINDOWS 	= 4;

		const LOGGED_DESKTOP	= 5;
		const LOGGED_TABLET 	= 6;
		const LOGGED_MOBILE 	= 7;

		const LOGGED_DEFAULT 	= 8;

		const GENDER_MALE		= 1;
		const GENDER_FEMALE		= 2;
		const GENDER_NONE		= 3;

		private static $instance;

		private $user=array();

		private $groups;
		private $default_unauthorized_key = array(0);

		/** @var boolean */
		private $unauthorized;
		public $no_set_back_url=null;

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
			$user_groups = $this->session->get('a_groups',Session::PREFIX_AUTH);
			if($user_groups){
				return $this->setLoggedGroups($user_groups);
			}
			return $this->setUnLoggedGroups();
		}

		public function setGroups(array $groups){
			$this->session->set('a_groups',$groups,Session::PREFIX_AUTH);
			return $this->getGroups();
		}

		private function setLoggedGroups($user_groups){
			$this->unauthorized = null;
//			$this->groups = array_combine(array_values($user_groups),array_values($user_groups));
			$this->groups = array_flip($user_groups);
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

		// set_cookie(fx_encode(Session::TOKEN_SESSION_KEY))
		// set_session(Session::TOKEN_SESSION_KEY,[ value ])
		public function validateAuthorize(){
			$auth_token = $this->session->get(Session::TOKEN_SESSION_KEY,Session::PREFIX_CONF);
			if($auth_token){
				if(!fx_equal(fx_encode($auth_token),$this->cookies->getCookie(Session::TOKEN_SESSION_KEY))){
					$this->session->cleanUserSession();
				}
			}
			return $this;
		}

		public function auth($auth_data,$member_me){
			$time = 0;
			if($member_me){
				$this->session->set(Session::MEMBER_SESSION_KEY,true,Session::PREFIX_CONF);
				$time = $this->config->session['session_time'];
			}
			$auth_cookie_key = fx_gen(128);
			$auth_cookie_hash = fx_encode($auth_cookie_key);

			foreach($auth_data as $key=>$value){
				$this->session->set($key,$value,Session::PREFIX_AUTH);
			}

			$this->cookies->setCookie(Session::TOKEN_SESSION_KEY,$auth_cookie_hash,$time);
			$this->session->set(Session::TOKEN_SESSION_KEY,$auth_cookie_key,Session::PREFIX_CONF);
			return $this;
		}

		public function escape(){
			$this->session->cleanUserSession();
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

		public function setBackUrl(){
			if($this->no_set_back_url){ return '/'; }
			$back_url = '/';
			$response = Response::getInstance();
			if(fx_equal($response->getResponseCode(),200)){
				$kernel = Kernel::getInstance();
				$back_url = fx_get_url($kernel->getCurrentController(),
					$kernel->getCurrentAction(), ...$kernel->getCurrentParams());
				$this->session->set('link_to_redirect',$back_url,Session::PREFIX_SESS);
			}
			return $back_url;
		}

		public function getBackUrl(){
			if(($back_url = $this->session->get('link_to_redirect',Session::PREFIX_SESS))){
				return $back_url;
			}
			return $this->setBackUrl();
		}

		public function resetCSRFToken(){
			$time = time();
			$csrf_token_time = $this->session->get('csrf_token_time',Session::PREFIX_CONF);
			if(!$this->getCSRFToken() || $csrf_token_time+$this->config->session['csrf_token_time'] < $time){
				$this->setCSRFToken();
			}
			$this->session->set('csrf_token_time',$time,Session::PREFIX_CONF);
			return $this;
		}

		public function setCSRFToken(){
			$this->session->set($this->config->session['csrf_key_name'],fx_gen(),Session::PREFIX_CONF);
			return $this;
		}

		public function getCSRFToken(){
			return $this->session->get($this->config->session['csrf_key_name'],Session::PREFIX_CONF);
		}
















	}














