<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Blog\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Blog\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Blog\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Blog\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Multiple;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Add_Post extends Form{

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
		}

		public function setCategories(array $categories,$current_category){
			$this->categories = $categories;
			$this->current_category = $current_category;
			return $this;
		}

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('blog','add'));
				$form->setFormValidation('novalidate');
			});

			$this->validator_interface->field('b_title')
				->htmlspecialchars()
//				->class('class')
				->id('title')
				->label(fx_lang('blog.title_field'))
				->placeholder(fx_lang('blog.title_field_placeholder'))
				->type('text')
				->check(function(Checkers $checkers){
					$checkers->max(191);
				});

			$this->validator_interface->field('b_image_preview_id')
				->htmlspecialchars()
//				->class('class')
				->id('image-field')
				->label(fx_lang('blog.add_image_to_form'))
				->type('hidden')
				->autocomplete('off')
				->params(function(Params $param){
					$param->field_type('image');
				})
				->check(function(Checkers $checkers){
					$checkers->max(191);
//					$checkers->int();
				});

			$this->validator_interface->field('b_content')
				->jevix(true)
//				->class('class')
				->id('content')
				->label(fx_lang('blog.content_field'))
				->placeholder(fx_lang('blog.content_field_placeholder'))
				->type('post')
				->params(function(Params $param){
					$param->field_sets_field_class('m-0 col-12');
					$param->field_sets('row col-12 p-0 m-0');
					$param->field_type('post')
						->wysiwyg();
				})
				->check(function(Checkers $checkers){
					$checkers->required();
				});

			$this->validator_interface->field('attachments')
				->prepare()
				->class('m-0')
				->id('attachments')
//				->label(fx_lang('attachments.attachments_field_label'))
				->type('attachments')
				->params(function(Params $param){
					$param->field_type('attachments');
					$param->field_sets('row col-12 m-0 p-0');
				})
				->check();

			$this->validator_interface->field('b_category_id')
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

			$this->validator_interface->field("b_comments_enabled")
				->prepare()
				->params(function(Params $params){
					$params->field_sets('comments');
					$params->field_type('switch');
					$params->show_validation(false);
					$params->field_sets_field_class('ml-2');
					$params->default_value(true);
				})
				->title(fx_lang('blog.comments_enabled'))
				->label(fx_lang('blog.comments_enabled'))
				->type('checkbox')
//				->class('simple')
				->id('enable_comments');

			$this->validator_interface->field("b_public")
				->prepare()
				->params(function(Params $params){
					$params->field_sets('access');
					$params->field_type('switch');
					$params->show_validation(false);
					$params->field_sets_field_class('ml-2');
					$params->default_value(true);
				})
				->title(fx_lang('blog.item_is_public'))
				->label(fx_lang('blog.item_is_public'))
				->type('checkbox')
//				->class('simple')
				->id('public');

			return $this;
		}

		public function checkFieldsList($post_data){
			$this->validator_interface
				->setData($post_data)
				->csrf(1)
				->validate(1);
			$this->checkCategory();
			return $this->generateFieldsList();
		}

		public function checkCategory(){
			$category = $this->getValue('b_category_id');
			if(fx_equal($category,'0') || isset($this->categories[$category])){
				return $this;
			}
			$this->setError(fx_lang('cats.error_category_select'));
			return $this;
		}


	}