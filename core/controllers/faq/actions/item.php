<?php

	namespace Core\Controllers\Faq\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Faq\Config;
	use Core\Controllers\Faq\Controller;
	use Core\Controllers\Faq\Model;

	class Item extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
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

		/** @var Session */
		public $session;

		/** @var array */
		public $item;
		public $item_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->item[$key])){
				return $this->item[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->item[$name] = $value;
			return $this->item[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function methodGet($item_id){
			$this->item_id = $item_id;

			$this->item = $this->model->getItemByID($item_id);

			if($this->item){

				$this->setMenuLinks();

				$this->response->controller('faq','item')
					->setArray(array(
						'item'	=> $this->item,
						'menu'	=> $this->menu
					));

				return $this->setResponse()
					->addResponse();
			}

			return false;
		}

		public function addResponse(){
			$title = fx_crop_string($this->item['f_question'],50);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setValue($title)
				->setLink('faq','item',$this->item['f_id'])
				->setIcon(null);
			return $this;
		}



















	}














