<?php

	namespace Core\Controllers\Audios\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Audios\Config;
	use Core\Controllers\Audios\Controller;
	use Core\Controllers\Audios\Forms\Edit_Audio;
	use Core\Controllers\Audios\Model;

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

		public $audio_id;
		public $user_id;
		public $audio_data;
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
			$this->edit_form = Edit_Audio::getInstance();
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($audio_id){
			$this->audio_id = $audio_id;
			$this->audio_data = $this->model->getUserAudioByID($this->user_id,$this->audio_id);

			$this->setResponse();

			if($this->audio_data){
				$this->addResponse();

				$this->edit_form->setData($this->audio_data)
					->setAudioID($this->audio_id);

				$this->edit_form->generateFieldsList();
				$this->response->controller('audios','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'audio'		=> $this->audio_data
					));
				return $this;
			}
			return false;
		}

		public function methodPost($audio_id){
			$this->audio_id = $audio_id;
			$this->audio_data = $this->model->getUserAudioByID($this->user_id,$this->audio_id);

			$this->setResponse();

			if($this->audio_data){
				$this->addResponse();

				$this->edit_form->setRequest($this->request)
					->setAudioID($this->audio_id);

				$this->edit_form->checkFieldsList();

				if($this->edit_form->can()){
					$this->update_data['au_name'] = $this->edit_form->getAttribute('au_name','value');
					$this->update_data['au_description'] = $this->edit_form->getAttribute('au_description','value');

					$audio_ext = pathinfo($this->audio_data['au_name'],PATHINFO_EXTENSION);
					$this->update_data['au_name'] = "{$this->update_data['au_name']}.{$audio_ext}";

					if($this->model->updateAudio($this->user_id,$this->audio_id,$this->update_data)){
						return $this->redirect(fx_get_url('audios','item',$this->audio_id));
					}
				}

				$this->response->controller('audios','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'audio'		=> $this->audio_data
					));
				return $this;
			}
			return false;
		}

		public function addResponse(){
			$title = fx_crop_file_name($this->audio_data['au_name'],30);

			$this->response->title($title);
			$this->response->breadcrumb('edit')
				->setValue($title)
				->setIcon(null)
				->setLink('audios','item',$this->audio_data['au_id']);
			return $this;
		}



















	}














