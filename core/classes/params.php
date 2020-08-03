<?php

	namespace Core\Classes;

	class Params{

		private static $instance;

		protected $current_controller;

		protected $params=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->params[$key])){
				return $this->params[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->params[$name] = $value;
			return $this->params[$name];
		}

		public function __construct(){
			$this->params = $this->loadParamsFromControllerFile();
		}

		public function loadParamsFromControllerFile($file='params',$controller=null){
			if(!$controller){
				$controller = $this->current_controller;
			}
			return fx_load_helper("core/controllers/{$controller}/config/{$file}",Kernel::IMPORT_INCLUDE);
		}


















	}














