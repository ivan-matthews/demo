<?php

	namespace Core\Controllers\Attachments;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var \Core\Classes\Model|Model */
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

		/** @var array */
		private $attachments;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->attachments[$key])){
				return $this->attachments[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->attachments[$name] = $value;
			return $this->attachments[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Attachments\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Attachments\Model as Model;
		}

		public function __destruct(){

		}

		public function getAttachmentsFromIDsList(array $ids_list, $user_id = null){
			$attachments_result = array();
			if(isset($ids_list['photos'])){
				$attachments_result['photos'] = $this->model->getPhotosAttachments($ids_list['photos'],$user_id);
			}
			if(isset($ids_list['videos'])){
				$attachments_result['videos'] = $this->model->getVideosAttachments($ids_list['videos'],$user_id);
			}
			if(isset($ids_list['audios'])){
				$attachments_result['audios'] = $this->model->getAudiosAttachments($ids_list['audios'],$user_id);
			}
			if(isset($ids_list['files'])){
				$attachments_result['files'] = $this->model->getFilesAttachments($ids_list['files'],$user_id);
			}
			return $attachments_result;
		}

		public function prepareAttachments(array $attachments,$field_name='attachments'){
			$attachments_result = array();
			if(isset($attachments[$field_name]['photos']) && $attachments[$field_name]['photos']){
				$attachments_result['photos'] = explode(',',$attachments[$field_name]['photos']);
			}
			if(isset($attachments[$field_name]['audios']) && $attachments[$field_name]['audios']){
				$attachments_result['audios'] = explode(',',$attachments[$field_name]['audios']);
			}
			if(isset($attachments[$field_name]['videos']) && $attachments[$field_name]['videos']){
				$attachments_result['videos'] = explode(',',$attachments[$field_name]['videos']);
			}
			if(isset($attachments[$field_name]['files']) && $attachments[$field_name]['files']){
				$attachments_result['files'] = explode(',',$attachments[$field_name]['files']);
			}
			return $attachments_result;
		}















	}














