<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;
	use Core\Controllers\Avatar\Forms\Add as AddForm;
	use Core\Controllers\Users\Model as UserModel;
	use Core\Controllers\Photos\Controller as ImagesController;

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
		public $user_name;

		public $avatar_id;
		public $image_params_list = array();
		public $avatar_data = array();

		public $avatar_add_form;
		public $fields_list;
		public $insert_data;
		public $user_model;

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

			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);

			$this->user_model = UserModel::getInstance();

			$this->avatar_add_form = AddForm::getInstance();

			$this->avatar_add_form->setFileMaxSize($this->params->file_size)
				->setAllowedFileTypes(...$this->params->file_types);
			$this->user_name = $this->session->get('u_full_name',Session::PREFIX_AUTH);

			$this->images_controller = ImagesController::getInstance();
		}

		public function methodGet($avatar_id){
			$this->avatar_id = $avatar_id;

			$this->avatar_data = $this->model->getAvatarByID($this->avatar_id,$this->user_id);

			if($this->avatar_data){
				$this->image_params_list['original'] = $this->avatar_data['p_original'];
				foreach($this->params->image_params as $key=>$value){
					$this->image_params_list[$key] = $this->avatar_data["p_{$key}"];
				}

				$this->avatar_add_form->generateFieldsList($this->user_id);

				$this->avatar_add_form->setParams('image_params',$this->params->image_params);

				$this->fields_list = $this->avatar_add_form->getFieldsList();

				$this->response->controller('avatar','edit')
					->setArray(array(
						'image_params'	=> $this->image_params_list,
						'fields'		=> $this->fields_list,
						'form'			=> $this->avatar_add_form->getFormAttributes(),
						'errors'		=> $this->avatar_add_form->getErrors()
					));

				$this->setResponse($this->avatar_data)
					->appendResponse();
				return $this;
			}

			return false;
		}

		public function methodPost($avatar_id){
			$this->avatar_id = $avatar_id;

			$this->avatar_data = $this->model->getAvatarByID($this->avatar_id,$this->user_id);

			if($this->avatar_data){
				$this->image_params_list['original'] = $this->avatar_data['p_original'];
				foreach($this->params->image_params as $key=>$value){
					$this->image_params_list[$key] = $this->avatar_data["p_{$key}"];
				}

				$image = array(
					'tmp_name'	=> fx_get_upload_root_path($this->avatar_data['p_original']),
					'name'		=> $this->avatar_data['p_name'],
					'type'		=> $this->avatar_data['p_mime'],
					'size'		=> $this->avatar_data['p_size']
				);

//				 форму валидировать не надо
//				 так, как никакие данные
//				 мы не принимаем
				$this->avatar_add_form->generateFieldsList($this->user_id);

				$this->avatar_add_form->setParams('image_params',$this->params->image_params);

				$this->fields_list = $this->avatar_add_form->getFieldsList();

				$image_params = $this->request->getAll();
				$x = isset($image_params['x'][0]) ? (int)$image_params['x'][0] : 0;
				$y = isset($image_params['y'][0]) ? (int)$image_params['y'][0] : 0;

				$this->insert_data = $this->images_controller->setOptions($this->params->image_params)
					->cropAndResizeImage(
						$image,
						$this->user_id,
						'photos',
						$x,
						$y,
						true,
						dirname($this->avatar_data['p_original'])
					);

				$this->avatar_id = $this->model->addAvatar($this->insert_data);

				if($this->avatar_id){
					if(fx_equal($this->avatar_data['u_avatar_id'],$this->avatar_data['p_id'])){
						$this->sessionUpdate($this->insert_data);
					}
					return $this->redirect();
				}

				$this->response->controller('avatar','edit')
					->setArray(array(
						'image_params'	=> $this->image_params_list,
						'fields'		=> $this->fields_list,
						'form'			=> $this->avatar_add_form->getFormAttributes(),
						'errors'		=> $this->avatar_add_form->getErrors()
					));

				$this->setResponse($this->avatar_data)
					->appendResponse();

				return $this;
			}

			return false;
		}

		public function appendResponse(){
			$this->response->title('avatar.edit_avatar_form_title');
			$this->response->breadcrumb('avatar_edit')
				->setValue('avatar.edit_avatar_form_title')
				->setLink('avatar','edit',$this->user_id,$this->avatar_id);

			return $this;
		}



















	}














