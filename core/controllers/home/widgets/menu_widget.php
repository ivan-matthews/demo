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
			$this->prepareLinks();
			return $this->links;
		}

		private function getMenuLinks(){
			$this->links = $this->model->getMenuLinksByWidgetId($this->params['wa_id']);
			return $this;
		}

		private function prepareLinks(){
			foreach($this->links as $key=>$value){
				$this->links[$key]['l_link_array'] = fx_url(fx_arr($value['l_link_array']));
			}
			return $this;
		}


	}