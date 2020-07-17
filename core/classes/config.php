<?php

	namespace Core\Classes;

	/**
	 * Class Config
	 * @package Core\Classes
	 * @property array $cache
	 * @property array $core
	 * @property array $cron
	 * @property array $database
	 * @property array $router
	 * @property array $secure
	 * @property array $session
	 * @property array $api
	 * @property array $mail
	 * @property array $view
	 */
	class Config{

		private static $instance;

		protected $config;
		protected $files_path;

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

		public function __construct(){
			$this->setConfigsPath("system/config")
				->getConfigs();
		}

		public function setConfigsPath($files_path){
			$this->files_path = fx_path($files_path);
			return $this;
		}

		public function getConfigs(){
			$this->config = fx_load_array($this->files_path,Kernel::IMPORT_INCLUDE);
			return $this;
		}

		public function getAll(){
			if(!$this->config){
				$this->getConfigs();
			}
			return $this->config;
		}






	}
































