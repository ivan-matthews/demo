<?php

	namespace Core\Controllers\Auth\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Auth_Form extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		private $form_name;

		/** @return $this */
		public static function getInstance($form_name=null){
			if(self::$instance === null){
				self::$instance = new self($form_name);
			}
			return self::$instance;
		}

		public function __construct($form_name=null){
			parent::__construct();
			$this->form_name = $form_name;
			$this->request = Request::getInstance();
		}

		public function generateFieldsList(){
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('auth','index'));
			});

			$this->validator_interface->field("login")
				->htmlspecialchars()
				->title(fx_lang('auth.login_field_title'))
				->label(fx_lang('auth.login_field_label'))
				->placeholder(fx_lang('auth.login_field_placeholder'))
				->type('email')
				->id('login')
				->class('form-control mt-2')
				->check(function(Checkers $checkers){
					$checkers->email();
					$checkers->max(191);
					$checkers->required();
				});

			$this->validator_interface->field("password")
				->dont_prepare()
				->title(fx_lang('auth.password_field_title'))
				->label(fx_lang('auth.password_field_label'))
				->placeholder(fx_lang('auth.password_field_placeholder'))
				->type('password')
				->id('password')
				->class('form-control mt-2')
				->check(function(Checkers $checkers){
					$checkers->min(6);
					$checkers->required();
					$checkers->lower_letters();
					$checkers->upper_letters();
					$checkers->numeric();
					$checkers->symbols('\!\@\#\$\%\^\&\*\(\)\_\+\=\-');
				});

			$this->validator_interface->field("remember_me")
				->value(true)
				->dont_prepare()
				->params(function(Params $params){
					$params->field_type('switch');
					$params->show_validation(false);
					$params->field_sets_field_class(null);
					$params->field_sets('member');
				})
				->title(fx_lang('auth.remember_me_title'))
				->label(fx_lang('auth.remember_me_label'))
				->class('custom-control-input')
				->type('checkbox')
				->id('remember_me');

			$this->validator_interface->setCaptcha();

			return $this->getFieldsList();
		}

		public function checkFieldsList(){
			$this->validator_interface
				->setData($this->request->getArray($this->form_name))
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList();
		}

	}