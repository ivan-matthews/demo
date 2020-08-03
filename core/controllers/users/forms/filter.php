<?php

	namespace Core\Controllers\Users\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	use Core\Widgets\Filter as FilterWidget;

	class Filter extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Session */
		protected $session;

		/** @var Request */
		private $request;

		public $form_name;
		public $filter_data = array();

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

		public function filter($form_action,$input_fields){
			$this->filter_data = $this->request->getArray('filter');

			$this->setFilter($form_action,$this->filter_data);
			$this->geo_filter('u_country_id','u_region_id','u_city_id');

			$this->setArrayFields($input_fields)
				->checkArrayFields();

			$this->filtrate();

			FilterWidget::add()
				->form($this->getFormAttributes())
				->fields($this->getFieldsList())
				->errors($this->getErrors())
				->data($this->filter_data)
				->set();
			return $this;
		}




















	}