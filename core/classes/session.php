<?php

	namespace Core\Classes;

	class Session{

		private static $instance;

		protected $session=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->session[$key])){
				return $this->session[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->session[$name] = $value;
			return $this->session[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public function is($key){
			if(isset($_SESSION[$key])){
				return true;
			}
			return false;
		}

		public function get($key){
			if($this->is($key)){
				return $_SESSION[$key];
			}
			return null;
		}

		public function un($key){
			if($this->is($key)){
				unset($_SESSION[$key]);
			}
			return true;
		}

		public function set($key,$value){
			$_SESSION[$key] = $value;
			return $this;
		}

















	}














