<?php

	namespace Core\Controllers\Files\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Files\Config;
	use Core\Controllers\Files\Controller;
	use Core\Controllers\Files\Model;

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

		/** @var string|integer */
		public $item_id;
		public $user_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->backLink();
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($item_id){
			$this->item_id = $item_id;
			if($this->model->deleteFile($this->user_id,$this->item_id)){
				return $this->redirect(fx_get_url('files','index'));
			}
			return false;
		}




















	}














