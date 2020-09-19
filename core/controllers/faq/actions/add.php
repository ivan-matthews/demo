<?php

	namespace Core\Controllers\Faq\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Faq\Config;
	use Core\Controllers\Faq\Controller;
	use Core\Controllers\Faq\Forms\Add_Form;
	use Core\Controllers\Faq\Model;
	use Core\Controllers\Categories\Controller as CatsController;

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

		public $add_form;
		public $insert_data;
		public $new_item_id;

		public $categories;				// список категорий
		public $cat_id;					// текущая категория
		public $cats_controller;

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
			$this->add_form = Add_Form::getInstance();
			$this->cats_controller = CatsController::getInstance();
			$this->cat_id = $this->cats_controller->getCurrentCategoryID();
			$this->categories = $this->cats_controller->setCategories('faq')
				->getCategories();
		}

		public function methodGet(){
			$this->add_form->setCategories($this->categories,$this->cat_id)
				->generateFieldsList();

			$this->response->controller('faq','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'=> $this->add_form->getFieldsList(),
					'errors'=> $this->add_form->getErrors()
				));

			return $this->setResponse()
				->addResponse();
		}

		public function methodPost(){
			$this->add_form->setCategories($this->categories,$this->cat_id);
			$this->add_form->checkFieldsList($this->request->getAll());

			if($this->add_form->can()){
				$this->insert_data['question']	= $this->add_form->getAttribute('question','value');
				$this->insert_data['answer']	= $this->add_form->getAttribute('answer','value');
				$this->insert_data['category']	= $this->add_form->getAttribute('category','value');

				$this->new_item_id = $this->model->addNewAnswer($this->insert_data);

				if($this->new_item_id){
					return $this->redirect(fx_get_url('faq','item',$this->new_item_id));
				}
			}

			$this->response->controller('faq','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'=> $this->add_form->getFieldsList(),
					'errors'=> $this->add_form->getErrors()
				));

			return $this->setResponse()
				->addResponse();
		}

		public function addResponse(){
			$this->response->title('faq.new_answer_form_title');
			$this->response->breadcrumb('add')
				->setValue('faq.new_answer_form_title')
				->setLink('faq','add')
				->setIcon(null);

			return $this;
		}




















	}














