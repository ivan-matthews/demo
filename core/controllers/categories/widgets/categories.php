<?php

	namespace Core\Controllers\Categories\Widgets;

	use Core\Classes\Kernel;
	use Core\Classes\Response\Response;
	use Core\Controllers\Categories\Model;
	use Core\Controllers\Categories\Controller;

	class Categories{

		private $params;
		private $response;
		private $model;
		private $kernel;
		private $controller;
		private $categories_controller;

		private $categories = array();
		private $current_category;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->model = Model::getInstance();
			$this->kernel = Kernel::getInstance();
			$this->controller = $this->kernel->getCurrentController();
			$this->categories_controller = Controller::getInstance();
		}

		public function run(){
			$this->categories = $this->categories_controller->setCategories($this->controller)
				->getControllerCategories();

			$this->setResponse();

			return array(
				'categories'	=> $this->categories,
				'controller'	=> $this->controller
			);
		}

		private function setResponse(){
			$link = fx_make_url(array($this->controller,'index'),array(
				'cat'	=> $this->categories_controller->getCurrentCategoryID()
			));

			$this->current_category = $this->categories_controller->getCurrentCategoryItem();
			if($this->current_category){
				$this->categories_controller->response->title($this->current_category['ct_title']);
				$this->categories_controller->response->breadcrumb('request')
					->setLink(trim($link,'/'))
					->setValue($this->current_category['ct_title'])
					->setIcon(/*$this->current_category['ct_icon']*/ null);
			}
			return $this;
		}
	}