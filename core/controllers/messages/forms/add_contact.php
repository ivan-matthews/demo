<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Messages\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Messages\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Messages\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Messages\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Add_Contact extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $user_id;

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

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList($user_id){		// для метода GET - генерирует поля
			$this->user_id = $user_id;

			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('messages','add',$this->user_id));
			});

			$this->validator_interface->field('message')
				->jevix(true)
				->class('add-message form-control')
				->id('add-message')
				->title(fx_lang('messages.add_message_form_title'))
				->type('textarea')
				->params(function(Params $param){
					$param->field_type('message');
					$param->field_sets_field_class('m-0 col-12');
					$param->field_sets('row col-12 p-0 m-0');
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

			return $this;
		}

		public function checkFieldsList($user_id){
			$this->user_id = $user_id;

			$this->validator_interface
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList($this->user_id);
		}

	}