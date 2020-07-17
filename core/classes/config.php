<?php

	namespace Core\Classes;

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
			$this->files_path = $files_path;
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
































