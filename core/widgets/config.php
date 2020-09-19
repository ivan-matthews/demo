<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;
	use Core\Classes\Config as CoreClassConfig;

	class Config{

		private $params;
		private $response;

		private $config;
		private $config_array;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->config = CoreClassConfig::getInstance();
		}

		public function run(){
			$this->getConfig();
//			$this->config_array = htmlspecialchars(fx_json_encode($this->config_array));
			return $this->config_array;
		}

		private function getConfig(){
			$this->config_array['view'] = $this->config->view;
			$this->config_array['uploads_root'] = fx_get_upload_path('');
			return $this;
		}









	}