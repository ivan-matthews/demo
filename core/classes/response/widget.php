<?php

	namespace Core\Classes\Response;

	class Widget{

		private $default_params = array(
			'data'		=> array(),
			'params'	=> array(),
		);

		private $widget_position;
		private $response;
		private $widget;

		public function __construct(Response $response,array $widget){
			$this->response = $response;
			$this->widget_position = $widget['wa_position'];
			$this->widget = $widget;
		}

		public function set($key,$value){
			$this->default_params[$key] = $value;
			return $this;
		}

		public function setArray(array $widget_data){
			$this->default_params = $widget_data;
		}

		public function add($index=null){
			$index = $index ? $index : $this->getNewIndex($this->widget_position,$this->widget['wa_ordering']);
			$this->response->response_data['response_data']['widgets'][$this->widget_position][$index] = $this->default_params;
			return true;
		}

		private function getNewIndex($position,$index){
			if(!isset($this->response->response_data['response_data']['widgets'][$position][$index])){
				return $index;
			}
			return $this->getNewIndex($position,$index + 1);
		}















	}














