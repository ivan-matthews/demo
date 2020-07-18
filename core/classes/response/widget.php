<?php

	namespace Core\Classes\Response;

	class Widget{

		private $default_params = array(
			'data'		=> array(),
			'params'	=> array(),
		);

		private $last_index;
		private $widget_position;
		private $response;

		public function __construct(Response $response,$widget_position){
			$this->response = $response;
			$this->widget_position = $widget_position;
			$this->last_index = $this->getLastArrayKey();
			$this->response->response_data['response_data']['widgets'][$this->widget_position][$this->last_index] = $this->default_params;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['widgets'][$this->widget_position][$this->last_index][$key] = $value;
			return $this;
		}

		public function setArray(array $widget_data){
			$this->response->response_data['response_data']['widgets'][$this->widget_position][$this->last_index] = $widget_data;
		}

		private function getLastArrayKey(){
			$this->response->response_data['response_data']['widgets'][$this->widget_position] =
				(isset($this->response->response_data['response_data']['widgets'][$this->widget_position])
					? $this->response->response_data['response_data']['widgets'][$this->widget_position]
					: array());
			$keys = array_keys($this->response->response_data['response_data']['widgets'][$this->widget_position]);
			$last_key = end($keys);
			$last_key++;
			return $last_key;
		}

		public function setIndex($last_index){
			$this->last_index = $last_index;
			return $this;
		}


















	}














