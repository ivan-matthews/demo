<?php

	namespace Core\Classes\Forms;

	use Core\Classes\Request;
	use Core\Classes\Forms\Interfaces\Field;
	use Core\Classes\Forms\Interfaces\Fields as FieldsInterface;
	use Core\Classes\Forms\Interfaces\Attributes;
	use Core\Classes\Forms\Interfaces\Params;
	use Core\Classes\Forms\Interfaces\Validator;
	use Core\Classes\Forms\Interfaces\Form as FormInterface;

	class Test extends Form{

		/** @var Field|FieldsInterface */
		protected $form_interface;

		private $form_name;
		private $request;
		private $array_fields;

		public function __construct($form_name){
			parent::__construct();
			$this->form_name = $form_name;
			$this->request = Request::getInstance();
		}

		public function setForm(){
			$this->form_name($this->form_name);
			$this->form_enctype('simple-enctype');
			$this->form_action('/simple/link/url');
			$this->form_method('simple_method');
		}

		public function setFieldsArray(){
			$this->array_fields = array(
				array(
					'field_name'	=> 'login',
					'field_type'	=> 'text',
					'field_required'	=> 1,
					'param_label'	=> 'login field',
					'validator_required'=>1,
				),
				array(
					'field_name'	=> 'password',
					'field_type'	=> 'password',
					'field_class'	=> 'simple',
				),
				array(
					'field_name'	=> 'member',
					'field_type'	=> 'checkbox',
					'param_label'	=> 'member me?',
				),
				array(
					'field_autocomplete'	=> 'off',
					'field_name'	=> 'simple',
					'field_type'	=> 'text',
					'field_placeholder'	=> 'simple placeholder!',
				),
			);
			return $this;
		}

		public function testArray(){
			$this->setData($this->request->getArray($this->form_name));
			$this->setForm();
			$this->setFieldsArray();
//			$this->validation(1);
//			$this->csrf();
			$this->setFormFieldsFromFiedsArray($this->array_fields);
			fx_die(
				$this->getForm(),
				$this->getFields()
			);
		}

		public function setFieldsList(){
//			$this->form_interface->validation(1);
			$this->form_interface->csrf();
			$this->form_interface->captcha();

			$this->form_interface->setData($this->request->getArray($this->form_name))
				->form(function(FormInterface $form){
					$form->form_title('title')
						->form_method('GEST')
						->form_action('link');
				});
			$this->form_interface->text('text',function(Attributes $attributes){
				$attributes->field_autocomplete('off');
				$attributes->field_type('text')
					->field_id('id')
					->field_min(21);
			})->params(function(Params $params){
				$params->param_label('label')
					->param_description('some descr')
					->param_show_in_form(false);
			})->check(function(Validator $validator){
				$validator->validator_symbols('\!\@\#\$\%\^\&')
					->validator_numeric(true)
					->validator_min(21)
					->validator_email(true);
			});
			fx_die(
				$this->getForm(),
				$this->getFields()
			);

		}















	}














