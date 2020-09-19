<?php

	namespace Core\Controllers\Videos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Videos\Config;
	use Core\Controllers\Videos\Controller;
	use Core\Controllers\Videos\Forms\Add_Videos;
	use Core\Controllers\Videos\Model;

	class Add extends Controller{

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
		public $add;

		public $user_id;

		/** @var Add_Videos */
		public $add_form;

		public $videos_list = array();

		public $insert_data = array();

		public $video_id;

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
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
			$this->add_form = Add_Videos::getInstance();
		}

		public function methodGet(){
			$this->setResponse()->addResponse();

			$this->add_form->generateFieldsList();

			$this->response->controller('videos','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));
			return $this;
		}

		public function methodPost(){
			$this->add_form->checkForm($this->request->getAll());

			$this->setResponse()->addResponse();

			if($this->add_form->can()){
				$this->videos_list = $this->add_form->getAttribute('videos','files');

				foreach($this->videos_list as $video_params){
					$this->setVideo($this->user_id,$video_params);
				}

				$this->video_id = $this->model->addVideos($this->insert_data);

				if($this->video_id){
					return $this->redirect(fx_get_url('users','videos',$this->user_id));
				}
			}

			$this->response->controller('videos','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));
			return $this;
		}

		public function setVideo($user_id,$video_params,$folder='videos'){
			$current_time = time();

			$extension 	= $this->getExt($video_params['name']);
			$hash 		= $this->getHash($video_params['tmp_name']);
			$video_name	= "{$hash}.{$extension}";

			$image_directory_suffix = mb_substr($hash,0,4);
			$first_folder = mb_substr($image_directory_suffix,0,2);
			$second_folder = mb_substr($image_directory_suffix,2,4);

			$folder 	= "{$user_id}/{$folder}/{$first_folder}/{$second_folder}";

			$directory 	= $this->setPath($folder);	// /var/www/m.c/public/uploads/users/1/path/to/video
			$dnl_link	= $this->setDownloadPath("{$folder}/{$video_name}");	// users/1/path/to/video

			fx_make_dir($directory);
			move_uploaded_file($video_params['tmp_name'],"{$directory}/{$video_name}");

			$this->insert_data[] = array(
				'v_user_id'			=> $this->user_id,
				'v_name'			=> $video_params['name'],
				'v_size'			=> $video_params['size'],
				'v_path'			=> $dnl_link,
				'v_hash'			=> "{$user_id}-{$hash}",
				'v_mime'			=> $video_params['type'],
				'v_date_created'	=> $current_time,
			);

			return $this;
		}

		public function getExt($video){
			return pathinfo($video,PATHINFO_EXTENSION);
		}

		public function setDownloadPath($folder){
			return "users/{$folder}";
		}

		public function setPath($folder){
			return fx_get_upload_root_path($this->setDownloadPath($folder));
		}

		public function getHash($video_path){
			return md5_file($video_path);
		}

		public function addResponse(){
			$this->response->title('videos.add_videos');
			$this->response->breadcrumb('add')
				->setValue('videos.add_videos')
				->setLink('videos','add')
				->setIcon(null);
			return $this;
		}


















	}














