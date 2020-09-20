<?php

	namespace Core\Classes\Response;

	use Core\Classes\Kernel;

	/**
	 * Class Response
	 * @package Core\Classes
	 * @method static Controller _controller($controller_name)
	 * @method static BreadCrumb _breadcrumb($breadcrumb)
	 * @method static Widget _widget($widget_name)
	 * @method static Title _title()
	 * @method static Meta _meta($meta)
	 * @method static Error _error($backtrace_key=2)
	 * @method static Debug _debug($debug_key,$backtrace_key=2)
	 * @method static Response _favicon($icon)
	 */
	class Response{

		private static $instance;
		
		protected $response;
		
		protected $response_list;

		public $response_data;

		public $default_array = array(
			'response_data'		=> array(
				'link_to_redirect'	=> '/',
				'headers'			=> array(
					'response_code'		=> 200,
					'response_status'	=> '200 OK',
				),

				'controller'		=> array(),
				'widgets'			=> array(),
				'title'				=> array(),
				'meta'				=> array(),
				'breadcrumb'		=> array(),
				'session_messages'	=> array(),
				'favicon'			=> '',
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

		public static function __callStatic($name, $arguments){
			$self = self::getInstance();
			$name = trim($name,'_');
			if(method_exists($self,$name)){
				return call_user_func(array($self,$name),...$arguments);
			}
			return $self;
		}

		public function __call($name, $arguments){
			return self::__callStatic($name,$arguments);
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
			$this->setResponseDataDefaultArray();
		}

		public function __destruct(){

		}

		public function setResponseDataDefaultArray(){
			$this->response_data = $this->default_array;
			return $this;
		}

		public function resetDebug(){
			unset($this->response_data['debug']);
			$this->response_data['debug'] = array();
			return $this;
		}

		public function resetErrors(){
			unset($this->response_data['errors']);
			$this->response_data['errors'] = array();
			return $this;
		}

		public function controller($controller_name,$action='index'){
			return new Controller(self::getInstance(),$controller_name,$action);
		}

		public function breadcrumb($breadcrumb=null){
			return new BreadCrumb(self::getInstance(),$breadcrumb);
		}

		public function widget($widget_array_data){
			return new Widget(self::getInstance(),$widget_array_data);
		}

		public function title($title_value=null){
			$title = new Title(self::getInstance());
			if($title_value){
				$title->set(fx_lang($title_value));
			}
			return $title;
		}

		public function meta($meta){
			return new Meta(self::getInstance(),$meta);
		}

		public function error($backtrace_key=2){
			return new Error(self::getInstance(),$backtrace_key);
		}

		public function debug($debug_key,$backtrace_key=2){
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

		/**
		 * alias for $this -> setHeader([header_key], [header_value])
		 *
		 * @param $header_key
		 * @param $header_value
		 * @return Response
		 */
		public function header($header_key,$header_value){
			return $this->setHeader($header_key,$header_value);
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
				header("{$key}: {$value}",true,$this->response_data['response_data']['headers']['response_code']);
			}
			header("HTTP/1.0 {$this->response_data['response_data']['headers']['response_status']}");
			header("HTTP/1.1 {$this->response_data['response_data']['headers']['response_status']}");
			header("HTTP/2 {$this->response_data['response_data']['headers']['response_status']}");
			header("Status: {$this->response_data['response_data']['headers']['response_status']}");
			http_response_code($this->response_data['response_data']['headers']['response_code']);
			return $this;
		}

		public function favicon($icon){
			$this->response_data['response_data']['favicon'] = $icon;
			return $this;
		}

		public function set($key,$value){
			$this->response_data['response_data'][$key] = $value;
			return $this;
		}














	}














