<?php

	namespace Core\Controllers\Files\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Files\Config;
	use Core\Controllers\Files\Controller;
	use Core\Controllers\Files\Forms\Edit_File;
	use Core\Controllers\Files\Model;

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

		public $file_id;
		public $user_id;
		public $file_data;
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
			$this->edit_form = Edit_File::getInstance();
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($file_id){
			$this->file_id = $file_id;
			$this->file_data = $this->model->getUserFileByID($this->user_id,$this->file_id);

			$this->setResponse();

			if($this->file_data){
				$this->addResponse();

				$this->edit_form->setData($this->file_data)
					->setFileID($this->file_id);

				$this->edit_form->generateFieldsList();
				$this->response->controller('files','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'file'		=> $this->file_data
					));
				return $this;
			}
			return false;
		}

		public function methodPost($file_id){
			$this->file_id = $file_id;
			$this->file_data = $this->model->getUserFileByID($this->user_id,$this->file_id);

			$this->setResponse();

			if($this->file_data){
				$this->addResponse();

				$this->edit_form->setRequest($this->request)
					->setFileID($this->file_id);

				$this->edit_form->checkFieldsList();

				if($this->edit_form->can()){
					$this->update_data['f_name'] = $this->edit_form->getAttribute('f_name','value');
					$this->update_data['f_description'] = $this->edit_form->getAttribute('f_description','value');

					$file_ext = pathinfo($this->file_data['f_name'],PATHINFO_EXTENSION);
					$this->update_data['f_name'] = "{$this->update_data['f_name']}.{$file_ext}";

					if($this->model->updateFile($this->user_id,$this->file_id,$this->update_data)){
						return $this->redirect(fx_get_url('files','item',$this->file_id));
					}
				}

				$this->response->controller('files','edit')
					->setArray(array(
						'form'	=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
						'file'		=> $this->file_data
					));
				return $this;
			}
			return false;
		}

		public function addResponse(){
			$title = fx_crop_file_name($this->file_data['f_name'],30);

			$this->response->title($title);
			$this->response->breadcrumb('edit')
				->setValue($title)
				->setIcon(null)
				->setLink('files','item',$this->file_data['f_id']);
			return $this;
		}



















	}














