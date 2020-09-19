<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Comments\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Comments\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Comments\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Comments\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Edit_Comment extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Session */
		protected $session;

		private $form_name;

		public $comment_id;

		public $hash;
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

		public function generateFieldsList($comment_id){
			$this->comment_id = $comment_id;

			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormClass('mbt-0');
				$form->setFormValidation('novalidate');
				$form->setFormAction(fx_get_url('comments','edit',$this->comment_id));
			});

			$this->validator_interface->field('comment')
				->jevix(true)
				->class('add-comment form-control radius-0')
				->id('add-comment')
				->title(fx_lang('comments.add_comment_form_title'))
				->type('textarea')
				->placeholder(fx_lang('comments.write_someone_placeholder'))
				->params(function(Params $param){
					$param->field_type('message')->wysiwyg();
					$param->field_sets('csrf');
					$param->field_sets_field_class('m-0 col-12');
					$param->field_sets('row col-12 p-0 m-0');
				})
				->check(function(Checkers $checkers){
					$checkers->required();
					$checkers->max(2000);
				});

			$this->validator_interface->field('attachments')
				->prepare()
				->class('float-right')
				->id('attachments')
//				->label(fx_lang('attachments.attachments_field_label'))
				->type('attachments')
				->params(function(Params $param){
					$param->field_type('attachments');
					$param->field_sets('row col-12 m-0 p-0');
				})
				->check();

			return $this;
		}

		public function checkFieldsList($comment_id){
			$this->validator_interface
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList($comment_id);
		}


	}