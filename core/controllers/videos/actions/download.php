<?php

	namespace Core\Controllers\Videos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Videos\Config;
	use Core\Controllers\Videos\Controller;
	use Core\Controllers\Videos\Model;

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

		public $video_id;
		public $video_data;

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

		public function methodGet($video_id){
			$this->video_id = $video_id;
			$this->video_data = $this->model->getVideoByID($this->video_id);

			if($this->video_data){
				if(!fx_me($this->video_data['v_user_id']) && fx_logged()){
					$this->model->updateTotalViewsVideo($this->video_id);
				}
				return $this->redirect(fx_get_upload_path($this->video_data['v_path'],true, $this->video_data['v_external']));
			}

			return $this;
		}




















	}














