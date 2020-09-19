<?php

	namespace Core\Controllers\Attachments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Attachments\Config;
	use Core\Controllers\Attachments\Controller;
	use Core\Controllers\Attachments\Model;

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

		public function __destruct(){

		}

		public function methodGet($item_id){
			return false;
		}

		public function methodPost($item_id){
			return false;
		}

		public function methodPut($item_id){
			return false;
		}

		public function methodHead($item_id){
			return false;
		}

		public function methodTrace($item_id){
			return false;
		}

		public function methodPatch($item_id){
			return false;
		}

		public function methodOptions($item_id){
			return false;
		}

		public function methodConnect($item_id){
			return false;
		}

		public function methodDelete($item_id){
			return false;
		}




















	}














