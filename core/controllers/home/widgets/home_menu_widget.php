<?php

	namespace Core\Controllers\Home\Widgets;


	class Home_Menu_Widget{

		private $params;
		private $data_result;

		public function __construct($params_list){
			$this->params = $params_list;
		}

		public function run(){
			$this->data_result = array(

			);
			return $this->data_result;
		}


	}