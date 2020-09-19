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
	use Core\Controllers\Attachments\Controller as AttachmentsController;
	use Core\Controllers\Categories\Controller as CatsController;

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

		public $add_form;
		public $update_data;

		public $item_id;
		public $faq_item;
		public $item_data;

		public $categories;				// список категорий
		public $cat_id;					// текущая категория
		public $cats_controller;

		/** @var AttachmentsController */
		public $attachments_controller;
		public $attachments_ids;
		public $attachments_data;

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

			$this->user_id = $this->user->getUID();
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

				$this->attachments_ids = fx_arr($this->faq_item['f_attachments_ids']);
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->add_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

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

				$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->add_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				if($this->add_form->can()){
					$this->update_data['question']	= $this->add_form->getAttribute('question','value');
					$this->update_data['answer']	= $this->add_form->getAttribute('answer','value');
					$this->update_data['category']	= $this->add_form->getAttribute('category','value');
					$this->update_data['attachments'] 	= $this->attachments_ids ? $this->attachments_ids : null;

					if($this->model->updateFaqAnswer($this->update_data,$this->item_id)){
						return $this->redirect(fx_get_url('faq','item',$this->item_id));
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














