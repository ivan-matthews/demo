<?php

	namespace Core\Widgets;

	use Core\Classes\Kernel;
	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Model;

	class Categories{

		private $params;
		private $response;
		private $model;
		private $kernel;
		private $controller;

		private $categories = array();

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->model = Model::getInstance();
			$this->kernel = Kernel::getInstance();
			$this->controller = $this->kernel->getCurrentController();
		}

		public function run(){
			$this->getCategories();
			return $this->categories;
		}

		private function getCategories(){
			$this->categories = $this->model->getCategoriesByCurrentController($this->controller);
			return $this;
		}
	}