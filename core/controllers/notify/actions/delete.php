<?php

	namespace Core\Controllers\Notify\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Notify\Config;
	use Core\Controllers\Notify\Controller;
	use Core\Controllers\Notify\Model;

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

		public $receiver_id;
		public $notice_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->receiver_id = $this->user->getUID();
			$this->backLink();
		}

		public function methodGet($notice_id=null){
			$this->notice_id = $notice_id;

			if(!$this->notice_id){
				$this->model->deleteAllNotices($this->receiver_id);
				return $this->redirect();
			}

			if($this->model->deleteNotice($this->notice_id)){
				return $this->redirect();
			}

			return false;
		}




















	}














