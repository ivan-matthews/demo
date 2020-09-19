<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Faq\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Faq\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Faq\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Faq\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Add_Form extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $categories;
		private $current_category;
		private $action;
		/**
		 * @param $form_name
		 * @return $this
		 */
		public static function getInstance($form_name=null){
			if(self::$instance === null){
				self::$instance = new self($form_name);
			}
			return self::$instance;
		}

		public function __construct($form_name=null){
			parent::__construct();
			$this->form_name = $form_name;

			$this->action = fx_get_url('faq','add');
		}

		public function setCategories(array $categories,$current_category){
			$this->categories = $categories;
			$this->current_category = $current_category;
			return $this;
		}

		public function setAction($action_link){
			$this->action = $action_link;
			return $this;
		}

		public function generateFieldsList(){
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction($this->action);
			});
			$this->validator_interface->field('question')
				->jevix(true)
				->class('form-control')
				->id('id')
				->title('title')
				->type('text')
				->placeholder(fx_lang('faq.write_question_title'))
				->params(function(Params $params){
					$params->field_type('simple');
				})
				->check();

			$this->validator_interface->field('answer')
				->jevix(true)
				->class('form-control')
				->id('id')
				->title('title')
				->type('text')
				->placeholder(fx_lang('faq.write_answer_title'))
				->params(function(Params $params){
					$params->field_type('post');
				})
				->check();

			$this->validator_interface->field('category')
				->prepare()
				->id('title')
				->label(fx_lang('home.categories_select_list'))
				->type('select')
				->params(function(Params $params){
					$params->field_type('select');
					$params->variants($this->categories);
					$params->default_value($this->current_category);
				})
				->check(function(Checkers $checkers){
					$checkers->max(191);
				});

			return $this;
		}

		public function checkFieldsList($request){
			$this->validator_interface
				->setData($request)
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList();
		}


	}