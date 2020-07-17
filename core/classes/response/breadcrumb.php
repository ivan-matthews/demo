<?php

	namespace Core\Classes\Response;

	class BreadCrumb{

		private $default_params = array(
			'link'	=> '',
			'icon'	=> '',
			'value'	=> '',
		);

		private $response;
		private $breadcrumb;

		public function __construct(Response $response,$breadcrumb){
			$this->response = $response;
			$this->breadcrumb = $breadcrumb;
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb] = $this->default_params;
		}

		public function setLink($link){
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb]['link'] = $link;
			return $this;
		}

		public function setIcon($icon){
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb]['icon'] = $icon;
			return $this;
		}

		public function setValue($value){
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb]['value'] = $value;
			return $this;
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb][$key] = $value;
			return $this;
		}

		public function setArray(array $breadcrumb_data){
			$this->response->response_data['response_data']['breadcrumb'][$this->breadcrumb] = $breadcrumb_data;
		}


















	}














