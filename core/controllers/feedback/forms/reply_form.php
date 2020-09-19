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

	class Reply_Form extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $item_id;

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

		public function setItemID($item_id){
			$this->item_id = $item_id;
			return $this;
		}

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList(){		// для метода GET - генерирует поля
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('feedback','reply',$this->item_id));
				$form->setFormValidation('novalidate');
			});

			$this->validator_interface->field('answer')
				->jevix(true)
				->class('form-control')
				->id('id')
				->title('title')
				->type('text')
				->placeholder(fx_lang('feedback.write_your_question'))
				->params(function(Params $params){
					$params->field_type('post');
				})
				->check(function(Checkers $checkers){
					$checkers->max(20000);
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