<?php

	namespace Core\Controllers\Home\Widgets;

	use Core\Controllers\Home\Model;

	class Menu_Widget{

		private $params;
		public $links;
		private $model;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->model = Model::getInstance();
		}

		public function run(){
			$this->getMenuLinks();
			return $this->links;
		}

		private function getMenuLinks(){
			$this->links = $this->model->getMenuLinksByWidgetId($this->params['id']);
			return $this;
		}

	}