<?php

	namespace Core\Controllers\Faq\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Faq\Config;
	use Core\Controllers\Faq\Controller;
	use Core\Controllers\Faq\Model;

	class Delete extends Controller{

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
		public $delete;

		public $item_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function methodGet($item_id){
			$this->item_id = $item_id;

			if($this->model->deleteAnswer($this->item_id)){
				return $this->redirect();
			}

			return false;
		}




















	}














