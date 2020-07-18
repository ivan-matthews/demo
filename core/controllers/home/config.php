<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Kernel;

	/**
	 * Class Config
	 * @package Core\Controllers\Home
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property boolean $just_widgets
	 * @property array $another_controller
	 */
	class Config{

		/** @var $this */
		private static $instance;

		/** @var array */
		private $params;

		/** @return $this */
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
			$this->params = $this->getParams();
		}

		public function __destruct(){

		}

		public function getParams(){
			return fx_load_helper('core/controllers/home/config/params',Kernel::IMPORT_INCLUDE);
		}

















	}














