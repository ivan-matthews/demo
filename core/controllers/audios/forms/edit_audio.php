<?php

	/*
		-------GET-------
	 		$form = new \Core\Controllers\Audios\Forms\Simple('form');
			$form->generateFieldsList();
			fx_die($form->getFieldsList());
		-------GET-------

		-------POST-------
			$form = new \Core\Controllers\Audios\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsList();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());

		--------OR--------
			$form = new \Core\Controllers\Audios\Forms\Simple();
			$form->setRequest(Request::getInstance());
			$form->checkFieldsFromArray();
			fx_die($form->can(),$form->getFieldsList(),$form->getErrors());
		--------OR--------

		-------POST-------
	*/

	namespace Core\Controllers\Audios\Forms;

	use Core\Classes\Form\Form;
	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Edit_Audio extends Form{

		/** @var $this */
		private static $instance;

		/** @var Validator */
		protected $validator_interface;

		/** @var Request */
		private $request;

		/** @var Session */
		protected $session;

		private $form_name;

		private $audio_id;

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

		public function setAudioID($audio_id){
			$this->audio_id = $audio_id;
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
				$form->setFormAction(fx_get_url('audios','edit',$this->audio_id));
			});
			$this->validator_interface->field('au_name')
				->htmlspecialchars(true)
				->id('name')
				->title('title')
				->type('text')
				->placeholder(fx_lang('audios.placeholder_name'))
				->label(fx_lang('audios.label_name'))
				->params(function(Params $params){
					$params->field_type('file_name');
				})
				->check(function(Checkers $checkers){
					$checkers->max(128);
					$checkers->required(true);
				});
			$this->validator_interface->field('au_description')
				->jevix(true)
				->id('description')
				->title('title')
				->type('textarea')
				->placeholder(fx_lang('audios.placeholder_description'))
				->label(fx_lang('audios.label_description'))
				->params(function(Params $params){
					$params->field_type('textarea');
				})
				->check(function(Checkers $checkers){
					$checkers->max(1024);
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

	}