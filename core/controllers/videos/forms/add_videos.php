<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Videos\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Videos\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Videos\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Videos\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Multiple;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Add_Videos extends Form{

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

		public function generateFieldsList(){
			$this->validator_interface->form(function(FormInterface $form){
				$form->setFormMethod('POST');
				$form->setFormName($this->form_name);
				$form->setFormAction(fx_get_url('videos','add'));
			});

			$this->validator_interface->field('videos')
				->prepare()
				->label(fx_lang('videos.select_videos'))
				->params(function(Params $params){
					$params->field_type('files');
					$params->show_validation(false);
				})
				->files(function(Multiple $multiple){
					$multiple->multiple()
						->accept('video',array(
							'mp4','flv'
						))
						->max_size(20 * 1024 * 1024);
//						->min_size(50*1024*1024);
				})
				->check();

			return $this;
		}

		public function checkForm(array $input_data){
			$this->validator_interface->setData($input_data);
			$this->validator_interface->csrf(1);
			$this->validator_interface->validate(1);

			return $this->generateFieldsList();
		}

	}