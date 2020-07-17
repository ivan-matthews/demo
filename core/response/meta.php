<?php

	namespace Core\Response;

	use Core\Classes\Response;

	class Meta{

		private $default_params = array(

		);

		private $response;
		private $meta;

		public function __construct(Response $response,$meta){
			$this->response = $response;
			$this->meta = $meta;
			$this->response->response_data['response_data']['meta'][$this->meta] = $this->default_params;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['meta'][$this->meta][$key] = $value;
			return $this;
		}

		public function setArray(array $meta_data){
			$this->response->response_data['response_data']['meta'][$this->meta] = $meta_data;
		}




















	}














