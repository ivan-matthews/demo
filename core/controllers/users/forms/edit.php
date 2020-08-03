<?php

	namespace Core\Controllers\Users\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Validator;

	class Edit extends Form{

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
		 * @param null $form_name
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

		public function setFields($fields,$user_data){
			$this->validator_interface->setData($user_data);
			$this->setArrayFields($fields);
			$this->checkArrayFields();
			return $this;
		}

		public function checkForm($fields,$user_data){
			$this->validator_interface->csrf(1);
			$this->validator_interface->validate(1);
			$this->validator_interface->setData($user_data);
			$this->setArrayFields($fields);
			$this->checkArrayFields();
			return $this;
		}









		

	}