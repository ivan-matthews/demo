<?php

	namespace Core\DB;

	class Alter{

		private static $instance;

		protected $alter;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->alter[$key])){
				return $this->alter[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->alter[$name] = $value;
			return $this->alter[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














