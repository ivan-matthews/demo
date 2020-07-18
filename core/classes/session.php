<?php

	namespace Core\Classes;

	class Session{

		const PREFIX_SESS = '__sess__';
		const PREFIX_AUTH = '__auth__';
		const PREFIX_CONF = '__conf__';
		const PREFIX_MSG = '__msg__';

		const MEMBER_SESSION_KEY = 'remember_session';
		const TOKEN_SESSION_KEY = 'auth_token';

		private static $instance;

		private $session=array();

		protected $session_dir;
		protected $session_id;
		protected $session_file;

		protected $cookies;
		protected $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __unset($name){
			if(isset($_SESSION[$name])){
				unset($_SESSION[$name]);
			}
			return true;
		}

		public function __get($key){
			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			}
			return null;
		}

		public function __set($name, $value){
			$_SESSION[$name] = $value;
			return $_SESSION[$name];
		}

		public function __construct(){
			$this->cookies = Cookie::getInstance();
			$this->config = Config::getInstance();
		}

		public function is($key,$prefix=null){
			$key = "{$prefix}{$key}";
			if(isset($_SESSION[$key])){
				return true;
			}
			return false;
		}

		public function get($key,$prefix=null){
			if($this->is($key,$prefix)){
				$key = "{$prefix}{$key}";
				return $_SESSION[$key];
			}
			return null;
		}

		public function drop($key,$prefix=null){
			if($this->is($key,$prefix)){
				$key = "{$prefix}{$key}";
				unset($_SESSION[$key]);
			}
			return true;
		}

		public function update($key,$value,$prefix=null){
			return $this->set($key,$value,$prefix);
		}

		public function set($key,$value,$prefix=null){
			$key = "{$prefix}{$key}";
			$_SESSION[$key] = $value;
			return $this;
		}

		public function setSessionDir($sub_folder=null){
			$this->session_dir = $this->config->session['session_path'];
			$this->session_dir .= $sub_folder ? "/{$sub_folder}" : '';
			$this->session_dir = fx_path($this->session_dir);
			fx_make_dir($this->session_dir);
			return $this;
		}

		public function setSessionID(){
			if($this->cookies->isCookie($this->config->session['session_name'])){
				$this->session_id = $this->cookies->getCookie($this->config->session['session_name']);
			}else{
				$this->session_id = fx_gen(rand($this->config->session['session_sid_min'],$this->config->session['session_sid_max']));
			}
			return $this;
		}

		public function setSessionFile(){
			$this->session_file = "{$this->session_dir}/sess_{$this->session_id}";
			return $this;
		}

		public function checkSessionFile(){
			if(file_exists($this->session_file)){
				$stat = stat($this->session_file);
				if(function_exists('posix_getuid') && !fx_equal($stat['uid'],posix_getuid())){
					unlink($this->session_file);
					$this->setSessionFile();
				}
			}
			return $this;
		}

		public function sessionStart(){
			ini_set('session.gc_maxlifetime', $this->config->session['session_time']);
			ini_set('session.cookie_lifetime', $this->config->session['session_time']);
			session_name($this->config->session['session_name']);
			session_save_path($this->session_dir);
			session_id($this->session_id);
			session_start();
			return $this;
		}

		public function cleanUserSession(){
			$this->cleanSessionData(self::PREFIX_AUTH);
			$this->cleanSessionData(self::PREFIX_CONF);
			$this->cleanSessionData(self::PREFIX_MSG);
			return $this;
		}

		private function cleanSessionData($session_key){
			foreach($_SESSION as $key=>$value){
				if(strpos($key,$session_key) !== false){
					$this->drop($key);
				}
			}
			return $this;
		}










	}














