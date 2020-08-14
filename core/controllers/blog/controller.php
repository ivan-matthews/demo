<?php

	namespace Core\Controllers\Blog;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Model as HomeModel;

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
		private $blog;

		public $categories;

		public $home_model;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->blog[$key])){
				return $this->blog[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->blog[$name] = $value;
			return $this->blog[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Blog\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Blog\Model as Model;

			$this->response->title($this->params->controller_name);
			$this->response->breadcrumb('blog')
				->setLink('blog','index')
				->setValue($this->params->controller_name)
				->setIcon(null);

			$this->home_model = HomeModel::getInstance();
			$this->setCategories();
		}

		public function __destruct(){

		}

		public function updateTotalViewsForPostItem($post_item,$user_id,$post_field_name='b_id'){
			if(fx_me($user_id)){ return $this; }
			return $this->model->updateTotalViewsForPostItem($post_item,$post_field_name);
		}

		public function makeSlugFromString($item_id,$item_title){
			$slug_string = fx_create_slug_from_string($item_title);
			$slug_string = "{$item_id}_{$slug_string}";
			return fx_crop_string($slug_string,80,null);
		}

		public function setCategories(){
			$categories = $this->home_model->getCategoriesByCurrentController('blog');
			if($categories){
				foreach($categories as $category){
					$this->categories[$category['ct_id']] = fx_lang($category['ct_title']);
				}
			}
			return $this;
		}














	}














