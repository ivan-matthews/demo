<?php

	namespace Core\Controllers\Auth\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Request;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Session;

	class Restore_Password_Confirm extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $login;

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
			$this->login = $this->session->get('login',Session::PREFIX_AUTH);
		}

		public function generateFieldsList(){

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
					$checkers->required(true);
					$checkers->lower_letters();
					$checkers->upper_letters();
					$checkers->numeric();
					$checkers->symbols('\!\@\#\$\%\^\&\*\(\)\_\+\=\-');
				});

			$this->validator_interface->field("password2")
				->dont_prepare()
				->title(fx_lang('auth.password2_field_title'))
				->label(fx_lang('auth.password2_field_label'))
				->placeholder(fx_lang('auth.password2_field_placeholder'))
				->type('password')
				->id('password')
				->class('form-control mt-2')
				->check(function(Checkers $checkers){
					$checkers->min(6);
					$checkers->required(true);
					$checkers->lower_letters();
					$checkers->upper_letters();
					$checkers->numeric();
					$checkers->symbols('\!\@\#\$\%\^\&\*\(\)\_\+\=\-');
				});

			return $this;
		}

		public function checkFieldsList(){
			$this->validator_interface
				->setData($this->request->getArray($this->form_name))
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList();
		}

		public function checkPasswords(){
			$this->field = 'password';
			$password = isset($this->data['password']) ? $this->data['password'] : null;
			$password2 = isset($this->data['password2']) ? $this->data['password2'] : null;
			if(fx_equal($password,$password2)){
				return $this;
			}
			$error = fx_lang('auth.passwords_not_equals',array(
				'%password%'	=> $password,
				'%password2%'	=> $password2,
			));
			$this->field = 'password';
			$this->setError($error);
			$this->field = 'password2';
			$this->setError($error);
			return $this;
		}

	}