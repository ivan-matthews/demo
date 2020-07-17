<?php

	namespace Core\DB\Connect;

	class PgSQL{

		private static $instance;

		protected $pgsql;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->pgsql[$key])){
				return $this->pgsql[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->pgsql[$name] = $value;
			return $this->pgsql[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}



















	}














