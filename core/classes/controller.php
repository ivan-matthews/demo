<?php

	namespace Core\Classes;

	use Core\Classes\Response\Response;

	class Controller{

		private static $instance;

		public $site_config;
		public $response;
		public $request;
		public $user;
		public $hook;

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
			$this->site_config = Config::getInstance();
			$this->response = Response::getInstance();
			$this->request = Request::getInstance();
			$this->user = User::getInstance();
			$this->hook = Hooks::getInstance();

			$this->response->title($this->site_config->core['site_name']);
			$this->response->breadcrumb('main_breadcrumb')
				->setValue($this->site_config->core['site_name'])
				->setLink()
				->setIcon('fa fa-home');
			$this->response->favicon($this->site_config->view['default_favicon']);
			$this->setMeta();
		}

		public function __destruct(){

		}

		public function redirect($link_to_redirect=null,$status_code=302){
			if(!$link_to_redirect){
				$link_to_redirect = $this->user->getBackUrl();
			}
			$link_to_redirect = trim($link_to_redirect,' /');
			$this->response->setResponseCode($status_code)
				->setHeader('Location',"/{$link_to_redirect}");
			return $this;
		}

		private function setMeta(){
			$this->response->meta('csrf')
				->set('name','csrf')
				->set('content',fx_csrf());
			$this->response->meta('charset')
				->set('charset','utf-8');
			$this->response->meta('description')
				->set('name','description')
				->set('content',$this->site_config->core['site_name']);
			$this->response->meta('generator')
				->set('name','generator')
				->set('content','simple generated values');
			$this->response->meta('viewport')
				->set('name','viewport')
				->set('content','width=device-width');

			$this->response->meta('http_equiv')
				->set('http-equiv','Content-Type')
				->set('content','text/html; charset=UTF-8');
			return $this;
		}

		public function dontSetBackLink(){
			$this->user->no_set_back_url = true;
			return false;
		}


















	}














