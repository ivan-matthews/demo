<?php

	namespace Core\Classes;

	class Cookie{

		private static $instance;

		private $cookie=array();
		private $current_time;

		public function __get($key){
			if(isset($this->cookie[$key])){
				return $this->cookie[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->cookie[$name] = $value;
			return $this->cookie[$name];
		}

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->current_time = time();
		}

		public function __destruct(){

		}

		public function isCookie($cookie){
			if(isset($_COOKIE[$cookie])){
				return $_COOKIE[$cookie];
			}
			return false;
		}

		public function getCookie($cookie_id){
			if($this->isCookie($cookie_id)){
				return $_COOKIE[$cookie_id];
			}
			return false;
		}

		public function setCookie($key, $value, $time=false, $path='/', $http_only=true, $domain = null){
			$time = !$time ? 0 : $this->current_time+$time;
			setcookie($key, $value, $time, $path, $domain, false, $http_only);
			return true;
		}

		public function unsetCookie($key, $time){
			if(isset($_COOKIE[$key])){
				unset($_COOKIE[$key]);
			}
			setcookie($key, '', $this->current_time-$time, '/');
			return true;
		}









	}