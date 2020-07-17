<?php

	namespace Core\Mail;

	class Mail{

		private static $instance;

		private $mail=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->mail[$key])){
				return $this->mail[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->mail[$name] = $value;
			return $this->mail[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














