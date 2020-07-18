<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Simple_Widget{

		private $params;
		private $response;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
		}

		public function run(){
			$this->response->widget($this->params['position'])
				->set('data',array(

				))
				->set('params',$this->params);
			return true;
		}

	}