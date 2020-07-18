<?php

	namespace Core\Classes\Response;

	use Core\Classes\Response;

	class Controller{

		private $default_params = array(

		);

		private $controller;
		private $action;
		private $response;

		public function __construct(Response $response,$controller,$action){
			$this->response = $response;
			$this->controller = $controller;
			$this->action = $action;
			$this->response->response_data['response_data']['controller'][$this->controller][$this->action] = $this->default_params;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['controller'][$this->controller][$this->action][$key] = $value;
			return $this;
		}

		public function setArray(array $controller_data){
			$this->response->response_data['response_data']['controller'][$this->controller][$this->action] = $controller_data;
			return $this;
		}












	}














