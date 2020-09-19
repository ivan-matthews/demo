<?php

	namespace Core\Controllers\Videos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Videos\Config;
	use Core\Controllers\Videos\Controller;
	use Core\Controllers\Videos\Forms\Edit_Video;
	use Core\Controllers\Videos\Model;

	class Edit extends Controller{

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
		public $edit;

		public $video_id;
		public $user_id;
		public $video_data;
		public $edit_form;
		public $update_data = array();

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
			$this->edit_form = Edit_Video::getInstance();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($video_id){
			$this->video_id = $video_id;
			$this->video_data = $this->model->getUserVideoByID($this->user_id,$this->video_id);

			$this->setResponse();

			if($this->video_data){
				$this->addResponse();

				$this->edit_form->setData($this->video_data)
					->setVideoID($this->video_id);

				$this->edit_form->generateFieldsList();
				$this->response->controller('videos','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'video'		=> $this->video_data
					));
				return $this;
			}
			return false;
		}

		public function methodPost($video_id){
			$this->video_id = $video_id;
			$this->video_data = $this->model->getUserVideoByID($this->user_id,$this->video_id);

			$this->setResponse();

			if($this->video_data){
				$this->addResponse();

				$this->edit_form->setRequest($this->request)
					->setVideoID($this->video_id);

				$this->edit_form->checkFieldsList();

				if($this->edit_form->can()){
					$this->update_data['v_name'] = $this->edit_form->getAttribute('v_name','value');
					$this->update_data['v_description'] = $this->edit_form->getAttribute('v_description','value');

					$video_ext = pathinfo($this->video_data['v_name'],PATHINFO_EXTENSION);
					$this->update_data['v_name'] = "{$this->update_data['v_name']}.{$video_ext}";

					if($this->model->updateVideo($this->user_id,$this->video_id,$this->update_data)){
						return $this->redirect(fx_get_url('videos','item',$this->video_id));
					}
				}

				$this->response->controller('videos','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'video'		=> $this->video_data
					));
				return $this;
			}
			return false;
		}

		public function addResponse(){
			$title = fx_crop_file_name($this->video_data['v_name'],30);

			$this->response->title($title);
			$this->response->breadcrumb('edit')
				->setValue($title)
				->setIcon(null)
				->setLink('videos','item',$this->video_data['v_id']);
			return $this;
		}



















	}














