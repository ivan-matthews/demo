<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Kernel;

	class Config{

		/** @var $this */
		private static $instance;

		/** @var array */
		private $config;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->config[$key])){
				return $this->config[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->config[$name] = $value;
			return $this->config[$name];
		}

		public function __construct(){
			$this->config = $this->getParams();
		}

		public function __destruct(){

		}

		public function getParams(){
			return fx_load_helper('core/controllers/home/config/params',Kernel::IMPORT_INCLUDE);
		}

















	}














