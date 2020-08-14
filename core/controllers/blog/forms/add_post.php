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

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('blog','add'));
			});

			$this->validator_interface->field('title')
				->htmlspecialchars()
//				->class('class')
				->id('title')
				->label(fx_lang('blog.title_field'))
				->placeholder(fx_lang('blog.title_field_placeholder'))
				->type('text')
				->check(function(Checkers $checkers){
					$checkers->max(185);
				});

			$this->validator_interface->field('image')
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
					$checkers->int();
				});

			$this->validator_interface->field('post_content')
				->jevix(true)
//				->class('class')
				->id('content')
				->label(fx_lang('blog.content_field'))
				->placeholder(fx_lang('blog.content_field_placeholder'))
				->type('textarea')
				->params(function(Params $param){
					$param->field_type('textarea');
				})
				->check(function(Checkers $checkers){
					$checkers->required();
				});

			$this->validator_interface->field("enable_comments")
				->dont_prepare()
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

			$this->validator_interface->field("public")
				->dont_prepare()
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
			return $this->generateFieldsList();
		}


	}