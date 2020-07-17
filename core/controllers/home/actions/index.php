<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hook;
	use Core\Classes\Request;
	use Core\Classes\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

	class Index extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		protected $config;

		/** @var Model */
		protected $model;

		/** @var \Core\Classes\Config */
		protected $site_config;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

		/** @var \Core\Classes\User */
		protected $user;
		/** @var Hook */
		protected $hook;

		/** @var array */
		private $index;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->index[$key])){
				return $this->index[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->index[$name] = $value;
			return $this->index[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->response->title(fx_lang('home.title_index_page'));
			$this->response->breadcrumb('index')
				->setValue(fx_lang('home.breadcrumb_index_page'))
				->setLink(fx_get_url('home','index'))
				->setIcon(null);
		}

		public function __destruct(){

		}

		public function methodGet(){

//			$this->model->indexModel();
//			$this->model->secondModel();

			$this->response->controller('home')
				->set('var','someone')
				->set('var1','this')
				->set('var2','is')
				->set('var3','not')
				->set('var4','somebody');
			$this->response->controller('home','some')
				->set('var','someone')
				->set('var1','this')
				->set('var2','is')
				->set('var3','not')
				->set('var4','somebody');
			$this->response->controller('some','item')
				->set('var','someone')
				->set('var1','this')
				->set('var2','is')
				->set('var3','not')
				->set('var4','somebody');
			$this->response->controller('home','outhem')
				->set('var','someone')
				->set('var1','this')
				->set('var2','is')
				->set('var3','not')
				->set('var4','somebody');
			return true;
		}

		public function methodPost(){
			fx_pre(__METHOD__);
			return true;
		}

		public function methodPut(){
			fx_pre(__METHOD__);
			return true;
		}

		public function methodHead(){
			return false;
		}

		public function methodTrace(){
			return false;
		}

		public function methodPatch(){
			return false;
		}

		public function methodOptions(){
			return false;
		}

		public function methodConnect(){
			return false;
		}

		public function methodDelete(){
			return false;
		}




















	}














