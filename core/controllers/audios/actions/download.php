<?php

	namespace Core\Controllers\Audios\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Audios\Config;
	use Core\Controllers\Audios\Controller;
	use Core\Controllers\Audios\Model;

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

		public $audio_id;
		public $audio_data;

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

		public function methodGet($audio_id){
			$this->audio_id = $audio_id;
			$this->audio_data = $this->model->getAudioByID($this->audio_id);

			if($this->audio_data){
				if(!fx_me($this->audio_data['au_user_id']) && fx_logged()){
					$this->model->updateTotalViewsAudio($this->audio_id);
				}
				return $this->redirect(fx_get_upload_path($this->audio_data['au_path']));
			}

			return $this;
		}




















	}














