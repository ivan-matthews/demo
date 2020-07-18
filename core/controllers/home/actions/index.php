<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;

	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

	class Index extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $config;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $site_config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $index;

		public $called_class_object;

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

			if($this->config->just_widgets){ return true; }

			if(class_exists($this->config->another_controller['class'])){
				$this->called_class_object = call_user_func(array($this->config->another_controller['class'],'getInstance'));
				return call_user_func_array(array(
					$this->called_class_object, $this->config->another_controller['method']
				),array($this->config->another_controller['params']));
			}

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
			return false;
		}

		public function methodPut(){
			return false;
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














