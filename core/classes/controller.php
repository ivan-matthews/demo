<?php

	namespace Core\Classes;

	class Controller{

		private static $instance;

		protected $response;
		protected $request;
		private $controller;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->controller[$key])){
				return $this->controller[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->controller[$name] = $value;
			return $this->controller[$name];
		}

		public function __construct(){
			$this->response = Response::getInstance();
			$this->request = Request::getInstance();
		}

		public function __destruct(){

		}

		protected function redirect($link_to_redirect='/',$status_code=302){
			$link_to_redirect = trim($link_to_redirect,' /');
			$this->response->setResponseCode($status_code)
				->setHeader('Location',"/{$link_to_redirect}");
			return $this;
		}


















	}














