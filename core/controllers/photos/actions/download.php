<?php

	namespace Core\Controllers\Photos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Photos\Config;
	use Core\Controllers\Photos\Controller;
	use Core\Controllers\Photos\Model;

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

		public $photo_id;
		public $photo_data;

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

		public function methodGet($photo_id){
			$this->photo_id = $photo_id;
			$this->photo_data = $this->model->getPhotoById($this->photo_id,"photos.p_status = " . Kernel::STATUS_ACTIVE);

			if($this->photo_data){
				if(!fx_me($this->photo_data['p_user_id']) && fx_logged()){
					$this->model->updateTotalViewsPhoto($this->photo_id);
				}
				return $this->redirect(fx_get_upload_path($this->photo_data['p_original'],true, $this->photo_data['p_external']));
			}

			return $this;
		}




















	}














