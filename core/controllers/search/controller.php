<?php

	namespace Core\Controllers\Search;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Widgets\Header_Bar;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var \Core\Classes\Model|Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $_search;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->search[$key])){
				return $this->search[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->search[$name] = $value;
			return $this->search[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Search\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Search\Model as Model;
		}

		public function __destruct(){

		}

		protected function header_bar(array $header_bar_data_from_params_array,array $tabs_link,$current_tab){
			foreach($header_bar_data_from_params_array as $key=>$value){
				$new_tabs_link = $tabs_link;
				$new_tabs_link[] = $key;
				$header_bar_data_from_params_array[$key]['link'] = $new_tabs_link;
			}

			Header_Bar::add()
				->data($header_bar_data_from_params_array)
				->current($current_tab)
				->template('controllers/search/widgets/header_bar')
				->set();
			return $this;
		}















	}














