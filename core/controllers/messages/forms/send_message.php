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

	class Send_Message extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $contact_id;
		private $receiver_id;

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

		public function generateFieldsList($contact_id,$receiver_id){		// для метода GET - генерирует поля
			$this->contact_id = $contact_id;
			$this->receiver_id = $receiver_id;

			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormClass('col-12 row p-0 m-0');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('messages','send',$this->contact_id,$this->receiver_id));
			});

			$this->validator_interface->field('message')
				->jevix(true)
				->class('add-message form-control radius-0')
				->id('add-message')
				->title(fx_lang('messages.add_message_form_title'))
				->type('textarea')
				->placeholder(fx_lang('messages.write_someone_placeholder'))
				->params(function(Params $param){
					$param->field_type('textarea');
					$param->field_sets_field_class('col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 mb-0');
					$param->field_sets('row col-12 p-0 m-0');
				});

			$this->validator_interface->field('submit')
				->jevix(true)
				->class('add-message-button form-control radius-0 btn-default')
				->id('add-message')
				->title(fx_lang('messages.add_message_form_title'))
				->type('submit')
				->params(function(Params $param){
					$param->field_type('submit');
					$param->field_sets_field_class('col-1 mb-0');
					$param->field_sets('row col-12 p-0 m-0');
					$param->default_value('<i class="fas fa-paper-plane"></i>');
				});
			return $this;
		}

		public function checkFieldsList($contact_id,$receiver_id){
			$this->contact_id = $contact_id;
			$this->receiver_id = $receiver_id;

			$this->validator_interface
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList($this->contact_id,$this->receiver_id);
		}

	}