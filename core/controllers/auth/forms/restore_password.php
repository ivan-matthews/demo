<?php

	namespace Core\Controllers\Auth\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Request;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;
	use Core\Classes\Session;
	use Core\Controllers\Auth\Model;

	class Restore_Password extends Form{

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
			$this->login = $this->session->get('a_login',Session::PREFIX_AUTH);
		}

		public function generateFieldsList(){
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('auth','restore_password'));
			});

			$this->validator_interface->field("login")
				->value($this->login)
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

			return $this;
		}

		public function checkFieldsList(){
			$this->validator_interface
				->setData($this->request->getArray($this->form_name))
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList();
		}

		public function checkLogin(Model $model){
			$this->field = 'login';
			$login = isset($this->data['login']) ? $this->data['login'] : null;
			$email = $model->emailExists($login);
			if($email){
				return $this;
			}
			$this->setError(fx_lang('auth.user_not_found',array(
				'%user_login%'	=> $login
			)));
			return $this;
		}

	}