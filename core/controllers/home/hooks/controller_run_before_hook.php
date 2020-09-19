<?php

	namespace Core\Controllers\Home\Hooks;

	use Core\Classes\Config;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller_Run_Before_Hook{

		private $kernel;
		private $request;
		private $config;
		private $response;

		public function __construct(){
			$this->config = Config::getInstance();
			$this->kernel = Kernel::getInstance();
			$this->request = Request::getInstance();
			$this->response = Response::getInstance();
		}

		/**
		 * Установка дефолтных параметров для HTML-шаблона
		 *
		 * @return boolean
		 */
		public function run(){
			$this->response->title($this->config->core['site_name']);
			$this->response->breadcrumb('main_breadcrumb')
				->setValue($this->config->core['site_name'])
				->setLink()
				->setIcon('fa fa-home');
			$this->response->favicon($this->config->view['default_favicon']);
			$this->setMeta();

			return true;
		}

		/**
		 * Установить параметры тега <meta> для HTML-шаблона
		 *
		 * @return $this
		 */
		protected function setMeta(){
			$this->response->meta('csrf')
				->set('name','csrf')
				->set('content',fx_csrf());
			$this->response->meta('charset')
				->set('charset','utf-8');
			$this->response->meta('description')
				->set('name','description')
				->set('content',$this->config->core['site_name']);
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


	}














