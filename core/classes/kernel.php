<?php

	namespace Core\Classes;

	class Kernel{

		private static $instance;

		protected $core;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->core[$key])){
				return $this->core[$key];
			}
			return false;
		}

		public function __construct(){
			print __METHOD__ . PHP_EOL . "<br>";
		}

	}














