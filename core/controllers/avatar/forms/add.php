<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Avatar\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Avatar\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Avatar\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Avatar\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Multiple;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Add extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Session */
		protected $session;

		protected $form_name;

		protected $user_id;
		protected $file_size = 5*1024*1024;		// 5mb
		protected $file_types = array();

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

		public function generateFieldsList($user_id){
			$this->user_id = $user_id;

			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('avatar','add',$this->user_id));
			});

			$this->validator_interface->field('avatar')
				->prepare()
				->params(function(Params $params){
					$params->field_type('avatar');
					$params->show_validation(false);
				})
				->files(function(Multiple $multiple){
					$multiple->single()
						->accept('image',$this->file_types)
						->max_size($this->file_size);
				})
				->check();

			return $this;
		}

		public function checkForm(array $input_data,$user_id){
			$this->user_id = $user_id;

			$this->validator_interface->setData($input_data);
			$this->validator_interface->csrf(1);
			$this->validator_interface->validate(1);

			return $this->generateFieldsList($this->user_id);
		}

		public function setFileMaxSize(int $file_size){
			$this->file_size = $file_size;
			return $this;
		}

		public function setAllowedFileTypes(...$file_types){
			$this->file_types = $file_types;
			return $this;
		}











	}