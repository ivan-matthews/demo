<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\__controller_namespace__\Forms\Simple('form');
			$form->generateFieldsList();
			fx_pre($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\__controller_namespace__\Forms\Simple('form');
			$form->setRequest(Request::getInstance())
				->checkFieldsList();
			fx_pre($form->can(),$form->getFieldsList(),$form->getErrors());
		-------POST-------
	*/

	namespace Core\Controllers\__controller_namespace__\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;

	class Simple extends Form{

		/** @var Request */
		private $request;
		/** @var Validator */
		private $validator_interface;

		public function __construct($form_name=null){
			parent::__construct();
			$this->setFormName($form_name);
			$this->validator_interface = $this->getDynamicValidatorInterface();
		}

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface
				->name('field')
				->class('class')
				->id('id')
				->type('checkbox')
				->check(function(Checkers $checkers){
					$checkers->int()
						->ip()
						->email()
						->url();
				});
			$this->validator_interface
				->name('field1')
				->class('class')
				->id('id')
				->type('checkbox')
				->check(function(Checkers $checkers){
					$checkers->int()
						->ip()
						->email()
						->url();
				});
			$this->validator_interface
				->name('field2')
				->class('class')
				->id('id')
				->type('checkbox')
				->check(function(Checkers $checkers){
					$checkers->int()
						->ip()
						->email()
						->url();
				});
			return $this;							// или return $this->getFieldsList(); - получить список полей
		}

		public function checkFieldsList(){			// для метода POST - проверяет поля
			$this->validator_interface
				->setData($this->request->getArray($this->form_name))
				->runFieldsValidation()
				->checkCSRF();
			return $this->generateFieldsList();		// список полей генерируем обязательно!
		}

	}