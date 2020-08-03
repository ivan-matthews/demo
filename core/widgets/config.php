<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;
	use Core\Classes\Config as CoreClassConfig;
	use Core\Classes\View;

	class Config{

		private $params;
		private $response;

		private $view;
		private $config;
		private $config_array;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->config = CoreClassConfig::getInstance();
			$this->view = View::getInstance();
		}

		public function run(){
			$this->getConfig();
			$this->config_array = htmlspecialchars(json_encode($this->config_array));
			return $this->config_array;
		}

		private function getConfig(){
			$this->config_array['view'] = $this->config->view;
			$this->config_array['uploads_root'] = $this->view->getUploadSiteRoot('');
			return $this;
		}









	}