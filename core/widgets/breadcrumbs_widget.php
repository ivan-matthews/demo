<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Breadcrumbs_Widget{

		private $params;
		private $response;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
		}

		public function run(){
			return array(

			);
		}

	}