<?php

	namespace Core\Classes;

	use Core\Classes\Interfaces\Request as RequestInterface;

	class Request implements RequestInterface{

		private static $instance;

		protected $raw_input_data;
		protected $real_request_method;
		protected $request_method;

		protected $request;

		/**
		 * @return RequestInterface
		 */
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
			$this->setRequestedData(fx_get_request());
//			$this->raw_input_data = file_get_contents('php://input');
			$this->real_request_method = strtoupper(fx_get_server('REQUEST_METHOD'));
			$this->request_method = strtoupper($this->get('method') ?: $this->real_request_method);
		}

// 		постман не тянет; дефицит ОЗУ; -> лонг-бокс
//		public function parseRawInputData(){
//			if($this->raw_input_data){
//
//			}
//		}

		public function setRequestMethod($method){
			if(!is_string($method)){ $method = ''; }
			$this->request_method = strtoupper($method);
			return $this;
		}

		public function getRequestMethod(){
			return $this->request_method;
		}

		public function setRequestedData($data){
			$this->request = fx_trim($data);
			return $this;
		}

		public function get($key,$var_type='string'){
			if(isset($this->request[$key])){
				if(fx_equal(gettype($this->request[$key]),$var_type)){
					return $this->request[$key];
				}
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

		public function isGet(){
			if(fx_equal($this->real_request_method,'GET')){
				return true;
			}
			return false;
		}
		public function isPost(){
			if(fx_equal($this->real_request_method,'POST')){
				return true;
			}
			return false;
		}

		public function isPut(){
			if(fx_equal($this->real_request_method,'PUT')){
				return true;
			}
			return false;
		}

		public function isHead(){
			if(fx_equal($this->real_request_method,'HEAD')){
				return true;
			}
			return false;
		}
		public function isTrace(){
			if(fx_equal($this->real_request_method,'TRACE')){
				return true;
			}
			return false;
		}
		public function isPatch(){
			if(fx_equal($this->real_request_method,'PATCH')){
				return true;
			}
			return false;
		}
		public function isOptions(){
			if(fx_equal($this->real_request_method,'OPTIONS')){
				return true;
			}
			return false;
		}
		public function isConnect(){
			if(fx_equal($this->real_request_method,'CONNECT')){
				return true;
			}
			return false;
		}
		public function isDelete(){
			if(fx_equal($this->real_request_method,'DELETE')){
				return true;
			}
			return false;
		}







	}














