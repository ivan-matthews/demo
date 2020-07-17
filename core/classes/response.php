<?php

	namespace Core\Classes;

	use Core\Response\BreadCrumb;
	use Core\Response\Controller;
	use Core\Response\Debug;
	use Core\Response\Error;
	use Core\Response\Meta;
	use Core\Response\SessionMessage;
	use Core\Response\Title;
	use Core\Response\Widget;

	class Response{

		private static $instance;
		
		protected $response;
		
		protected $response_list;
		
		public $response_data = array(
			'response_data'		=> array(
				'headers'			=> array(
					'response_code'		=> 200,
					'response_status'	=> '200 OK',
				),

				'controller'		=> array(),
				'widget'			=> array(),
				'title'				=> array(),
				'meta'				=> array(),
				'breadcrumb'		=> array(),
				'session_message'	=> array(),
			),
			'errors'			=> array(),
			'debug'				=> array(),
		);

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->response[$key])){
				return $this->response[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->response[$name] = $value;
			return $this->response[$name];
		}

		public function __construct(){
			
		}

		public function __destruct(){

		}

		public static function controller($controller_name){
			return new Controller(self::getInstance(),$controller_name);
		}

		public static function breadcrumb($breadcrumb){
			return new BreadCrumb(self::getInstance(),$breadcrumb);
		}

		public static function widget($widget_name){
			return new Widget(self::getInstance(),$widget_name);
		}

		public static function title(){
			return new Title(self::getInstance());
		}

		public static function metaTag($meta){
			return new Meta(self::getInstance(),$meta);
		}

		public static function sessionMessage($message){
			return new SessionMessage(self::getInstance(),$message);
		}

		public static function error($backtrace_key=2){
			return new Error(self::getInstance(),$backtrace_key);
		}

		public static function debug($debug_key,$backtrace_key=2){
			return new Debug(self::getInstance(),$debug_key,$backtrace_key);
		}

		public function getAll(){
			return $this->response_data;
		}

		public function getData(){
			return $this->response_data['response_data'];
		}

		public function getErrors(){
			return $this->response_data['errors'];
		}

		public function getDebug(){
			return $this->response_data['debug'];
		}

		public function setHeader($header_key,$header_value){
			$this->response_data['response_data']['headers'][$header_key] = $header_value;
			return $this;
		}

		public function setResponseCode($code){
			$this->getResponseCodesList();
			if(isset($this->response_list[$code])){
				$this->response_data['response_data']['headers']['response_code'] = $code;
				$this->setResponseStatus($this->response_list[$code]);
			}
			return $this;
		}

		public function setResponseStatus($status){
			$this->response_data['response_data']['headers']['response_status'] = $status;
			return $this;
		}

		public function getResponseCode(){
			return $this->response_data['response_data']['headers']['response_code'];
		}

		public function getResponseStatus(){
			return $this->response_data['response_data']['headers']['response_status'];
		}

		private function getResponseCodesList(){
			if(!$this->response_list){
				$this->response_list = fx_load_helper("system/assets/response_codes",Kernel::IMPORT_INCLUDE);
			}
			return $this;
		}

		public function sendHeaders(){
			foreach($this->response_data['response_data']['headers'] as $key=>$value){
				if(fx_equal($key,'response_status')){ continue; }
				if(fx_equal($key,'response_code')){ continue; }
				@header("{$key}: {$value}",true,$this->response_data['response_data']['headers']['response_code']);
			}
			@header("HTTP/1.0 {$this->response_data['response_data']['headers']['response_status']}");
			@header("HTTP/1.1 {$this->response_data['response_data']['headers']['response_status']}");
			@header("HTTP/2 {$this->response_data['response_data']['headers']['response_status']}");
			@header("Status: {$this->response_data['response_data']['headers']['response_status']}");
			@http_response_code($this->response_data['response_data']['headers']['response_code']);
			return $this;
		}















	}














