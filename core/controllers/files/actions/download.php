<?php

	namespace Core\Controllers\Files\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Files\Config;
	use Core\Controllers\Files\Controller;
	use Core\Controllers\Files\Model;

	class Download extends Controller{

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
		public $download;

		public $file_id;
		public $file_data;

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

		public function methodGet($file_id){
			$this->file_id = $file_id;
			$this->file_data = $this->model->getFileByID($this->file_id);

			if($this->file_data){
				if(!fx_me($this->file_data['f_user_id']) && fx_logged()){
					$this->model->updateTotalViewsFile($this->file_id);
				}
				return $this->redirect(fx_get_upload_path($this->file_data['f_path'],true, $this->file_data['f_external']));
			}

			return $this;
		}




















	}














