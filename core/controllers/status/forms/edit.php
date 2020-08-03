<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Status\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Status\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Status\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Status\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

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

		public function setRequest(Request $request){
			$this->request = $request;
			return $this;
		}

		public function generateFieldsList($item_id){
			$this->item_id = $item_id;

			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('status','edit',$this->item_id));
			});
			$this->validator_interface->field('s_status')
				->jevix(true)
				->title(fx_lang('status.status_field_title'))
				->label(fx_lang('status.status_field_label'))
				->placeholder(fx_lang('status.status_field_placeholder'))
				->type('text')
				->id('status-field')
				->class('form-control mt-2 status-field')
				->check(function(Checkers $checkers){
					$checkers->max(255);
				});
			return $this;
		}

		public function checkFieldsList($input_data,$item_id){
			$this->item_id = $item_id;

			$this->validator_interface
				->setData($input_data)
				->csrf(1)
				->validate(1);
			return $this->generateFieldsList($this->item_id);
		}










	}