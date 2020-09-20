<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Feedback\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Feedback\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Feedback\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Feedback\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Send_Form extends Form{

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

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('feedback','send'));
			});

			$this->validator_interface->field('fb_name')
				->htmlspecialchars(true)
				->class('form-control')
				->id('fb_name')
//				->title('title')
				->type('text')
				->label(fx_lang('feedback.write_your_name_label'))
				->placeholder(fx_lang('feedback.write_your_name'))
				->params(function(Params $params){
					$params->field_type('simple');
				})
				->check(function(Checkers $checkers){
					$checkers->max(191);
					$checkers->required(true);
				});

			$this->validator_interface->field('fb_phone')
				->htmlspecialchars(true)
				->class('form-control')
				->id('fb_phone')
//				->title('title')
				->type('text')
				->label(fx_lang('feedback.write_your_phone_label'))
				->placeholder(fx_lang('feedback.write_your_phone'))
				->params(function(Params $params){
					$params->field_type('simple');
				})
				->check(function(Checkers $checkers){
					$checkers->max(191);
					$checkers->phone(true);
					$checkers->required(true);
				});

			$this->validator_interface->field('fb_email')
				->htmlspecialchars(true)
				->class('form-control')
				->id('fb_email')
//				->title('title')
				->type('email')
				->label(fx_lang('feedback.write_your_email_label'))
				->placeholder(fx_lang('feedback.write_your_email'))
				->params(function(Params $params){
					$params->field_type('simple');
				})
				->check(function(Checkers $checkers){
					$checkers->max(191);
					$checkers->email();
					$checkers->required(true);
				});

			$this->validator_interface->field('fb_content')
				->jevix(true)
				->class('form-control')
				->id('fb_content')
//				->title('title')
				->type('text')
				->label(fx_lang('feedback.write_your_question_label'))
				->placeholder(fx_lang('feedback.write_your_question'))
				->params(function(Params $params){
					$params->field_type('textarea');
				})
				->check(function(Checkers $checkers){
					$checkers->max(2000);
					$checkers->required(true);
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


	}