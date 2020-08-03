<?php

	namespace Core\Controllers\Status\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Status\Config;
	use Core\Controllers\Status\Controller;
	use Core\Controllers\Status\Forms\Edit as EditForm;
	use Core\Controllers\Status\Model;

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
		public $edit_form;
		public $form_data;
		public $fields_list;
		public $errors;
		public $data_to_update;
		public $user_id;
		public $user_name;
		public $status_id;

		public $input_data;
		public $status_data;

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
			$this->user_name = $this->session->get('u_full_name',Session::PREFIX_AUTH);
			$this->edit_form = EditForm::getInstance('status');

			$this->input_data = $this->request->getArray('status');
		}

		public function methodGet($status_id){
			$this->status_id = $status_id;

			$this->edit_form->generateFieldsList($this->status_id);

			$this->fields_list = $this->edit_form->getFieldsList();

			$this->status_data = $this->model->getStatusItemById($this->status_id);

			$this->fields_list['s_status']['attributes']['value'] = $this->status_data['s_content'];

			$this->setResponseData();

			$this->response->controller('status','add')
				->setArray(array(
					'fields'	=> $this->fields_list,
					'form'		=> $this->edit_form->getFormAttributes(),
					'errors'	=> $this->edit_form->getErrors()
				));

			return $this;
		}

		public function methodPost($status_id){
			$this->status_id = $status_id;

			$this->edit_form->checkFieldsList($this->input_data,$this->status_id);

			$this->fields_list = $this->edit_form->getFieldsList();

			if($this->edit_form->can()){

				$this->data_to_update = array(
					's_user_id'			=> $this->user_id,
					's_status'			=> Kernel::STATUS_ACTIVE,
					's_content'			=> $this->fields_list['s_status']['attributes']['value'],
					's_date_updated'	=> time()
				);

				$this->status_id = $this->model->editStatus($this->data_to_update,$this->status_id);

				if($this->status_id){
					return $this->redirect();
				}
			}

			$this->setResponseData();

			$this->response->controller('status','add')
				->setArray(array(
					'fields'	=> $this->fields_list,
					'form'		=> $this->edit_form->getFormAttributes(),
					'errors'	=> $this->edit_form->getErrors()
				));

			return $this;
		}

		public function setResponseData(){
			$this->response->title($this->user_name);
			$this->response->breadcrumb('user_item')
				->setValue($this->user_name)
				->setLink('users','item',$this->user_id);

			$this->response->title('status.edit_status_form_title');
			$this->response->breadcrumb('status_add')
				->setValue('status.edit_status_form_title')
				->setLink('status','edit',$this->status_id);

			return $this;
		}



















	}














