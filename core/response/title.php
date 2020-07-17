<?php

	namespace Core\Response;

	class Title{

		private $response;

		public function __construct($response){
			$this->response = $response;
		}

		public function set($value){
			$this->response->response_data['response_data']['title'][] = $value;
			return $this;
		}

		public function setArray(array $title_data){
			$this->response->response_data['response_data']['title'] = $title_data;
		}



















	}














