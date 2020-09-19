<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;
	use Core\Classes\Language as CoreClassLanguage;

	class Language{

		private $params;
		private $response;
		private $language;
		private $language_array;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->language = CoreClassLanguage::getInstance();
			$this->language_array = $this->language->getLanguage();
		}

		public function run(){
//			$this->language_array = htmlspecialchars(json_encode($this->language_array));
			return $this->language_array;
		}

	}