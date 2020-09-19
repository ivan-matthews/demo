<?php

	namespace Core\Controllers\Photos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Photos\Config;
	use Core\Controllers\Photos\Controller;
	use Core\Controllers\Photos\Model;
	use Core\Controllers\Photos\Forms\Add_Photos;

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
		public $add_form;
		public $fields_list;

		public $insert_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
			$this->add_form = Add_Photos::getInstance();

			$this->add_form->setFileMaxSize($this->params->file_size)
				->setAllowedFileTypes(...$this->params->file_types);
		}

		public function methodGet(){

			$this->add_form->setParams('image_params',$this->params->image_params);

			$this->add_form->generateFieldsList($this->user_id);

			$this->response->controller('photos','add')
				->setArray(array(
					'fields'	=> $this->add_form->getFieldsList(),
					'form'		=> $this->add_form->getFormAttributes(),
					'errors'	=> $this->add_form->getErrors()
				));

			$this->setResponse()
				->addResponse();

			return $this;
		}

		public function methodPost(){

			$this->add_form->setParams('image_params',$this->params->image_params);

			$this->add_form->checkForm($this->request->getAll(), $this->user_id);

			$this->fields_list = $this->add_form->getFieldsList();

			if($this->add_form->can()){
				foreach($this->fields_list['images']['attributes']['files'] as $index=>$file){
					$this->insert_data[$index] = $this->setOptions($this->params->image_params)
						->cropAndResizeImage(
							$file,$this->user_id,'photos',null,null
						);
				}
				if($this->model->addPhotos($this->insert_data)){
					return $this->redirect(fx_get_url('photos','user',$this->user_id));
				}
			}

			$this->response->controller('photos','add')
				->setArray(array(
					'fields'	=> $this->fields_list,
					'form'		=> $this->add_form->getFormAttributes(),
					'errors'	=> $this->add_form->getErrors()
				));

			$this->setResponse()
				->addResponse();

			return $this;
		}

		public function addResponse(){
			$this->response->title('photos.add_photos');
			$this->response->breadcrumb('add')
				->setValue('photos.add_photos')
				->setIcon(null)
				->setLink('photos','add');
			return $this;
		}



















	}














