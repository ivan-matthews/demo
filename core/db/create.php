<?php

	namespace Core\DB;

	class Create{

		private static $instance;

		protected $create;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->create[$key])){
				return $this->create[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->create[$name] = $value;
			return $this->create[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














