<?php

	namespace Core\Controllers\Feedback\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Mail\Notice;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Feedback\Config;
	use Core\Controllers\Feedback\Controller;
	use Core\Controllers\Feedback\Forms\Send_Form;
	use Core\Controllers\Feedback\Model;

	class Send extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var Session */
		public $session;

		/** @var array */
		public $send;

		public $send_form;
		public $form_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->backLink();
			$this->send_form = Send_Form::getInstance();
			$this->setResponse()
				->addResponse();
		}

		public function methodGet(){

			$this->send_form->generateFieldsList();

			$this->send_form->setCaptcha();

			$this->response->controller('feedback','send')
				->setArray(array(
					'form'		=> $this->send_form->getFormAttributes(),
					'fields'	=> $this->send_form->getFieldsList(),
					'errors'	=> $this->send_form->getErrors()
				));

			return $this;
		}

		public function methodPost(){

			$this->send_form->setRequest($this->request);

			$this->send_form->checkFieldsList();

			$this->send_form->setCaptcha();

			if($this->send_form->can()){
				$this->form_data['fb_name']	= $this->send_form->getAttribute('fb_name','value');
				$this->form_data['fb_phone']= $this->send_form->getAttribute('fb_phone','value');
				$this->form_data['fb_email']= $this->send_form->getAttribute('fb_email','value');
				$this->form_data['fb_content']	= $this->send_form->getAttribute('fb_content','value');

				if($this->model->addFeedbackQuestion($this->form_data)){

					Notice::ready()
						->theme('feedback.new_feedback_item')
						->sender($this->form_data['fb_email'])
						->receiver(1)
						->manager(Notice::MANAGER_NOTIFY)
						->action('feedback','requests','new')
						->key('feedback')
						->content(fx_crop_string($this->form_data['fb_content']))
						->create()
						->send();

					return $this->redirect();
				}
			}

			$this->response->controller('feedback','send')
				->setArray(array(
					'form'		=> $this->send_form->getFormAttributes(),
					'fields'	=> $this->send_form->getFieldsList(),
					'errors'	=> $this->send_form->getErrors()
				));

			return $this;
		}

		public function addResponse(){
			$this->response->title('feedback.send_form_action');
			$this->response->breadcrumb('send')
				->setValue('feedback.send_form_action')
				->setIcon(null)
				->setLink('feedback','send');
			return $this;
		}



















	}














