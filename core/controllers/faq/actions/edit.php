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

		public $add_form;
		public $update_data;

		public $item_id;
		public $faq_item;
		public $item_data;

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
		}

		public function methodGet($item_id){
			$this->item_id = $item_id;
			$this->faq_item = $this->model->getItemByID($this->item_id);

			if($this->item_id){
				$this->item_data = array(
					'question'	=> $this->faq_item['f_question'],
					'answer'	=> $this->faq_item['f_answer'],
					'category'	=> $this->faq_item['f_category_id'],
				);

				$this->add_form->setAction(fx_get_url('faq','edit',$this->item_id));
				$this->add_form->setData($this->item_data);
				$this->add_form->setCategories($this->categories,$this->faq_item['f_category_id'])
					->generateFieldsList();

				$this->response->controller('faq','edit')
					->setArray(array(
						'form'	=> $this->add_form->getFormAttributes(),
						'fields'=> $this->add_form->getFieldsList(),
						'errors'=> $this->add_form->getErrors()
					));

				return $this->setResponse()
					->addResponse();
			}
			return false;
		}

		public function methodPost($item_id){
			$this->item_id = $item_id;
			$this->faq_item = $this->model->getItemByID($this->item_id);

			if($this->item_id){
				$this->item_data = array(
					'question'	=> $this->faq_item['f_question'],
					'answer'	=> $this->faq_item['f_answer'],
					'category'	=> $this->faq_item['f_category_id'],
				);

				$this->add_form->setAction(fx_get_url('faq','edit',$this->item_id));
				$this->add_form->setCategories($this->categories,$this->cat_id)
					->checkFieldsList($this->request->getAll());

				if($this->add_form->can()){
					$this->update_data['question']	= $this->add_form->getAttribute('question','value');
					$this->update_data['answer']	= $this->add_form->getAttribute('answer','value');
					$this->update_data['category']	= $this->add_form->getAttribute('category','value');

					if($this->model->updateFaqAnswer($this->update_data,$this->item_id)){
						return $this->redirect();
					}
				}

				$this->response->controller('faq','edit')
					->setArray(array(
						'form'	=> $this->add_form->getFormAttributes(),
						'fields'=> $this->add_form->getFieldsList(),
						'errors'=> $this->add_form->getErrors()
					));

				return $this->setResponse()
					->addResponse();
			}
			return false;
		}

		public function addResponse(){
			$this->response->title('faq.edit_answer_form_title');
			$this->response->breadcrumb('add')
				->setValue('faq.edit_answer_form_title')
				->setLink('faq','add')
				->setIcon(null);

			return $this;
		}




















	}














