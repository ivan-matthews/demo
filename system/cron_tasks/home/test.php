<?php

	namespace System\Cron_Tasks\Home;

	use Core\Console\Interfaces\Types;
	use Core\Console\Paint;

	class Test{

		private static $instance;

		protected $test=array();

		private $method;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->test[$key])){
				return $this->test[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->test[$name] = $value;
			return $this->test[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public function execute(...$params){
			sleep(2);
			return $this->method = __METHOD__;
		}


















	}














