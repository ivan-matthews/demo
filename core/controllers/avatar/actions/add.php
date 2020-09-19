<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;
	use Core\Controllers\Users\Model as UsersModel;
	use Core\Controllers\Avatar\Forms\Add as AddForm;
	use Core\Controllers\Photos\Controller as ImagesController;

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

		/** @var AddForm */
		public $add_form;
		public $form_name = null;				// для файлов нельзя передавать имя формы
												// из-за костыльного сг-массива _FILES
												// иначе ошибки полезут

		public $fields_list=array();

		public $user_id;
		public $user_name;
		public $user_model;

		public $avatar_id;

		public $file_info;
		public $insert_data;
		public $avatar_data = array();

		public $images_controller;

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

			$this->user_id = $this->user->getUID();

			$this->user_model = UsersModel::getInstance();

			$this->add_form = AddForm::getInstance($this->form_name);

			$this->add_form->setFileMaxSize($this->params->file_size)
				->setAllowedFileTypes(...$this->params->file_types);

			$this->images_controller = ImagesController::getInstance();
		}

		public function methodGet(){

			$this->add_form->generateFieldsList($this->user_id);

			$this->avatar_data = $this->user_model->getUserByID($this->user_id);

			if($this->avatar_data){

				$this->add_form->setParams('image_params',$this->params->image_params);

				$this->fields_list = $this->add_form->getFieldsList();

				$this->response->controller('avatar','add')
					->setArray(array(
						'fields'	=> $this->fields_list,
						'form'		=> $this->add_form->getFormAttributes(),
						'errors'	=> $this->add_form->getErrors()
					));

				$this->setResponse($this->avatar_data)
					->appendResponse();

				return $this;

			}
			return false;
		}

		public function methodPost(){

			$this->add_form->checkForm($this->request->getArray($this->form_name),$this->user_id);

			$this->add_form->setParams('image_params',$this->params->image_params);

			$this->fields_list = $this->add_form->getFieldsList();

			$this->avatar_data = $this->user_model->getUserByID($this->user_id);

			if($this->add_form->can()){

				$image_params = $this->request->getAll();
				$x = isset($image_params['x'][0]) ? (int)$image_params['x'][0] : 0;
				$y = isset($image_params['y'][0]) ? (int)$image_params['y'][0] : 0;

				$this->insert_data = $this->images_controller->setOptions($this->params->image_params)
					->cropAndResizeImage(
						$this->fields_list['avatar']['attributes']['files'],
						$this->user_id,'photos',$x,$y
					);

				$this->avatar_id = $this->model->addAvatar($this->insert_data);

				if($this->avatar_id){

					$this->user_model->updateAvatarId($this->user_id,$this->avatar_id);

					$this->sessionUpdate($this->insert_data);

					return $this->redirect();
				}
			}

			$this->response->controller('avatar','add')
				->setArray(array(
					'fields'	=> $this->add_form->getFieldsList(),
					'form'		=> $this->add_form->getFormAttributes(),
					'errors'	=> $this->add_form->getErrors()
				));

			$this->setResponse($this->avatar_data)
				->appendResponse();

			return $this;
		}

		public function appendResponse(){
			$this->response->title('avatar.add_avatar_form_title');
			$this->response->breadcrumb('avatar_add')
				->setValue('avatar.add_avatar_form_title')
				->setLink('avatar','add');
			return $this;
		}




















	}














