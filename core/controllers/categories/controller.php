<?php

	namespace Core\Controllers\Categories;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

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
		private $categories;

		public $current_category;		// ID категории контента из GET[cat]

		public $categories_list;
		public $controller_categories;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->categories[$key])){
				return $this->categories[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->categories[$name] = $value;
			return $this->categories[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Categories\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Categories\Model as Model;
			$this->current_category = $this->request->get('cat');
		}

		public function __destruct(){

		}

		public function setCategories($controller){
			$this->controller_categories = $this->model->getCategoriesByCurrentController($controller);
			if($this->controller_categories){
				$categories = array();
				foreach($this->controller_categories as $category){
					$category['ct_title'] = fx_lang($category['ct_title']);
					$categories[$category['ct_id']] = $category;
					$this->categories_list[$category['ct_id']] = $category['ct_title'];
				}
				$this->controller_categories = $categories;
			}
			return $this;
		}

		public function getCurrentCategoryItem(){
			if(isset($this->controller_categories[$this->current_category])){
				return $this->controller_categories[$this->current_category];
			}
			return false;
		}

		public function setCurrentCategoryID($current_category){
			$this->current_category = $current_category;
			return $this;
		}

		public function getCurrentCategoryID(){
			return $this->current_category;
		}

		public function getCategories(){
			return $this->categories_list;
		}

		public function getControllerCategories(){
			return $this->controller_categories;
		}

















	}














