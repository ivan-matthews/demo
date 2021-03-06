<?php

	namespace Core\Controllers\Status\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Status\Config;
	use Core\Controllers\Status\Controller;
	use Core\Controllers\Status\Forms\Simple;
	use Core\Controllers\Status\Model;
	use Core\Controllers\Users\Model as UserModel;

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
		public $add_form;
		public $form_data;
		public $fields_list;
		public $errors;
		public $data_to_insert;
		public $user_id;
		public $user_name;
		public $status_id;

		public $user_model;

		public $input_data;

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
			$this->user_name = $this->session->get('u_full_name',Session::PREFIX_AUTH);
			$this->add_form = Simple::getInstance('status');

			$this->input_data = $this->request->getArray('status');
			$this->user_model = UserModel::getInstance();
		}

		public function methodGet($user_id){
			$this->user_id = $user_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->add_form->generateFieldsList($this->user_id);

			$this->response->controller('status','add')
				->setArray(array(
					'fields'	=> $this->add_form->getFieldsList(),
					'form'		=> $this->add_form->getFormAttributes(),
					'errors'	=> $this->add_form->getErrors()
				));

			$this->setResponse();

			return $this;
		}

		public function methodPost($user_id){
			$this->user_id = $user_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->add_form->checkFieldsList($this->input_data,$this->user_id);

			$this->fields_list = $this->add_form->getFieldsList();

			if($this->add_form->can()){

				$this->data_to_insert = array(
					's_user_id'			=> $this->user_id,
					's_status'			=> Kernel::STATUS_ACTIVE,
					's_content'			=> $this->fields_list['s_status']['attributes']['value'],
					's_date_created'	=> time()
				);

				$this->status_id = $this->model->addStatus($this->data_to_insert);

				if($this->status_id){

					$this->user_model->updateStatusId($this->user_id,$this->status_id);

					return $this->redirect();
				}
			}

			$this->setResponse();

			$this->response->controller('status','add')
				->setArray(array(
					'fields'	=> $this->fields_list,
					'form'		=> $this->add_form->getFormAttributes(),
					'errors'	=> $this->add_form->getErrors()
				));

			return $this;
		}

		public function setResponse(){
			$this->response->title('users.users_index_title');
			$this->response->breadcrumb('users')
				->setIcon(null)
				->setLink('users','index')
				->setValue('users.users_index_title');

			$this->response->title($this->user_name);
			$this->response->breadcrumb('user_item')
				->setValue($this->user_name)
				->setLink('users','item',$this->user_id);

			$this->response->title('status.add_status_form_title');
			$this->response->breadcrumb('status_add')
				->setValue('status.add_status_form_title')
				->setLink('status','add',$this->user_id);
			return $this;
		}



















	}














