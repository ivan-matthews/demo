<?php

	namespace Core\Response;

	use Core\Classes\Response;

	class Widget{

		private $default_params = array(

		);

		private $widget;
		private $response;

		public function __construct(Response $response,$widget){
			$this->response = $response;
			$this->widget = $widget;
			$this->response->response_data['response_data']['widget'][$this->widget] = $this->default_params;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['widget'][$this->widget][$key] = $value;
			return $this;
		}

		public function setArray(array $widget_data){
			$this->response->response_data['response_data']['widget'][$this->widget] = $widget_data;
		}


















	}














