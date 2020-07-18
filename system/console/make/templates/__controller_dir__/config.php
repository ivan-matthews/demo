<?php

	namespace Core\Controllers\__controller_namespace__;

	use Core\Classes\Kernel;

	/**
	 * Class Config
	 * @package Core\Controllers\__controller_namespace__
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 */
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

		public function getParams($file='params'){
			return fx_load_helper("core/controllers/__controller_property__/config/{$file}",Kernel::IMPORT_INCLUDE);
		}


















	}














