<?php

	namespace Core\Response;

	use Core\Classes\Response;

	class Controller{

		private $default_params = array(

		);

		private $controller;
		private $response;

		public function __construct(Response $response,$controller){
			$this->response = $response;
			$this->controller = $controller;
			$this->response->response_data['response_data']['controller'][$this->controller] = $this->default_params;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['controller'][$this->controller][$key] = $value;
			return $this;
		}

		public function setArray(array $controller_data){
			$this->response->response_data['response_data']['controller'][$this->controller] = $controller_data;
			return $this;
		}












	}














