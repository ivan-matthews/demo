<?php

	namespace Core\Controllers\Users\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	use Core\Widgets\Filter as FilterWidget;

	class Item extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Session */
		protected $session;

		/** @var Request */
		private $request;

		public $form_name;

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
			$this->request = Request::getInstance();
		}

		public function getFields($input_fields){
			$this->setArrayFields($input_fields)
				->checkArrayFields();
			return $this->getFieldsList();
		}



















	}