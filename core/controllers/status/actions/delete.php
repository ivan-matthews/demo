<?php

	namespace Core\Controllers\Status\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Status\Config;
	use Core\Controllers\Status\Controller;
	use Core\Controllers\Status\Model;

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

		public $data_to_delete;
		public $status_id;
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
		}

		public function methodGet($user_id,$status_id){
			$this->user_id = $user_id;
			if(!fx_me($this->user_id)){ return false; }
			$this->status_id = $status_id;

			$this->data_to_delete = array(
				's_status'			=> Kernel::STATUS_DELETED,
				's_date_deleted'	=> time(),
				's_user_id'			=> $this->user_id,
			);
			$this->status_id = $this->model->deleteStatus($this->data_to_delete,$this->status_id);

			if($this->status_id){
				return $this->redirect();
			}

			return false;
		}





















	}














