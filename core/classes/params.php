<?php

	namespace Core\Classes;

	class Params{

		private static $instance;

		protected $current_controller;

		protected $params=array();

		protected $param_files = array();

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
			$controller = !$controller ? $this->current_controller : $controller;

			if(!isset($this->param_files[$controller][$file])){
				$this->setParamFile($file,$controller);
			}

			return $this->param_files[$controller][$file];
		}

		public function setParamFile($file='params',$controller=null){
			$this->param_files[$controller][$file] = fx_load_helper("core/controllers/{$controller}/config/{$file}");
			return $this;
		}

		public function controllerExists($controller){
			$controller_params = $this->loadParamsFromControllerFile('params',$controller);
			if(fx_equal($controller_params['status'],Kernel::STATUS_ACTIVE)){
				return true;
			}
			return false;
		}
















	}














