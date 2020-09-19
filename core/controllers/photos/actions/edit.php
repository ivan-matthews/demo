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
	use Core\Controllers\Photos\Forms\Edit_Photo;

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

		public $user_id;

		public $photo_id;
		public $photo_data;
		public $edit_form;

		public $update_data;

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
			$this->query .= "photos.p_status = " . Kernel::STATUS_ACTIVE;
			$this->edit_form = Edit_Photo::getInstance();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($photo_id){
			$this->photo_id = $photo_id;
			$this->photo_data = $this->model->getPhotoById($this->photo_id,$this->query);

			$this->setResponse();

			if($this->photo_data){
				$this->addResponse();

				$this->edit_form->setData($this->photo_data);

				$this->edit_form->setPhotoID($this->photo_id);
				$this->edit_form->generateFieldsList();

				$this->response->controller('photos','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'photo'	=> $this->photo_data,
					));
				return $this;
			}
			return false;
		}

		public function methodPost($photo_id){
			$this->photo_id = $photo_id;
			$this->photo_data = $this->model->getPhotoById($this->photo_id,$this->query);

			$this->setResponse();

			if($this->photo_data){
				$this->addResponse();

				$this->edit_form->setRequest($this->request);

				$this->edit_form->setPhotoID($this->photo_id);
				$this->edit_form->checkFieldsList();

				if($this->edit_form->can()){
					$this->update_data['p_name'] = $this->edit_form->getAttribute('p_name','value');
					$this->update_data['p_description'] = $this->edit_form->getAttribute('p_description','value');

					$file_info = explode('/',$this->photo_data['p_mime']);
					$this->update_data['p_name'] = "{$this->update_data['p_name']}.{$file_info[1]}";

					if($this->model->updatePhoto($this->user_id,$this->photo_id,$this->update_data)){
						return $this->redirect();
					}
				}

				$this->response->controller('photos','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'photo'	=> $this->photo_data,
					));
				return $this;
			}
			return false;
		}

		public function addResponse(){
			$this->response->title($this->photo_data['p_name']);
			$this->response->breadcrumb('edit')
				->setValue($this->photo_data['p_name'])
				->setIcon(null)
				->setLink('photos','item',$this->photo_data['p_id']);
			return $this;
		}

















	}














