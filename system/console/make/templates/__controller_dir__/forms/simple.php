<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\__controller_namespace__\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\__controller_namespace__\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\__controller_namespace__\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\__controller_namespace__\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Simple extends Form{

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		private $form_name;

		public function __construct($form_name=null){
			parent::__construct();
			$this->form_name = $form_name;
		}

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('GET');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('__controller_namespace__','index'));
			});
			$this->validator_interface->field('field')->jevix(true)
				->class('class')
				->id('id')
				->title('title')
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
				->csrf(1)				// false|true - не|проверять CSRF-токены
				->validate(1);				// false|true - не|запускать валидатор
			return $this->generateFieldsList();		// список полей генерируем обязательно!
		}

		/*---------------OR---------------*/

		public function generateFieldsFromArray(){
			return array(
				array(
					'name'		=> 'field_name',
					'type'		=> 'checkbox',
					'field_type'=> 'checkbox',
					'id'		=> 'field_name',
					'data'		=> array(
						array(
							'key'	=> 'test_key_1',
							'value'	=> 'test-value-1'
						),
						array(
							'key'	=> 'test_key2',
							'value'	=> 'test-value-2'
						)
					),
					'attribute'		=> 'simple',
					'required'	=> true,
					'float'		=> true,
				),
			);
		}

		public function checkFieldsFromArray(){					// для метода POST - проверяет поля
			$this->validator_interface->csrf(1);
			$this->validator_interface->validate(1);
			$this->validator_interface->setData($this->request->getArray($this->form_name));
			$this->setArrayFields($this->generateFieldsFromArray());
			$this->checkArrayFields();
			return $this;
		}

	}