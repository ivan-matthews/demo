<?php

	namespace Core\Classes;

	class Request{

//		const DEF_REQUEST_METHOD = 'GET';

		private static $instance;

		protected $request_method;

		protected $request;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->request[$key])){
				return $this->request[$key];
			}
			return null;
		}

		public function __set($name, $value){
			$this->request[$name] = $value;
			return $this->request[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public function setRequestMethod($method){
			if(!is_string($method)){ $method = ''; }
			$this->request_method = strtoupper($method);
		}

		public function getRequestMethod(){
			return $this->request_method;
		}

		public function setRequestedData($data){
			$this->request = $data;
			return $this;
		}

		public function get($key){
			if(isset($this->request[$key])){
				return $this->request[$key];
			}
			return null;
		}

		public function getArray($key){
			if(isset($this->request[$key])){
				return $this->request[$key];
			}
			return $this->request;
		}

		public function getAll(){
			return $this->request;
		}









	}














