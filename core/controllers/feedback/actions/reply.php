<?php

	namespace Core\Controllers\Feedback\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Mail\Mail;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Feedback\Config;
	use Core\Controllers\Feedback\Controller;
	use Core\Controllers\Feedback\Forms\Reply_Form;
	use Core\Controllers\Feedback\Model;

	class Reply extends Controller{

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
		public $reply;

		public $reply_form;

		public $item_id;

		public $item_data;
		public $answer;

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
			$this->reply_form = Reply_Form::getInstance();
		}

		public function methodGet($item_id){
			$this->item_id = $item_id;

			$this->item_data = $this->model->getFeedbackItemByID($this->item_id);

			if($this->item_data){

				if(!$this->item_data['fb_date_updated'] && !fx_equal((int)$this->item_data['fb_status'],Kernel::STATUS_INACTIVE)){
					$this->model->readFeedbackItem($this->item_id);
				}

				$this->reply_form->setItemID($this->item_id);

				$this->reply_form->generateFieldsList();

				$this->setResponse();

				$this->response->controller('feedback','reply')
					->setArray(array(
						'form'	=> $this->reply_form->getFormAttributes(),
						'fields'=> $this->reply_form->getFieldsList(),
						'errors'=> $this->reply_form->getErrors(),
						'item'	=> $this->item_data
					));
				return $this;
			}

			return false;
		}

		public function methodPost($item_id){
			$this->item_id = $item_id;

			$this->item_data = $this->model->getFeedbackItemByID($this->item_id);

			if($this->item_data){

				$this->reply_form->setItemID($this->item_id);
				$this->reply_form->setRequest($this->request);
				$this->reply_form->checkFieldsList();

				$this->setResponse();

				if($this->reply_form->can()){
					$this->answer = $this->reply_form->getAttribute('answer','value');

					Mail::set('admin')
						->subject(fx_lang('feedback.answer_to_your_question'))
						->to($this->item_data['fb_email'],$this->item_data['fb_name'])
						->html('feedback_answer',array(
							'item_data'	=> $this->item_data,
							'answer'	=> $this->answer
						))
						->send();
					$this->model->updateAnswer($this->item_id,$this->answer);
					return $this->redirect();
				}

				$this->response->controller('feedback','reply')
					->setArray(array(
						'form'	=> $this->reply_form->getFormAttributes(),
						'fields'=> $this->reply_form->getFieldsList(),
						'errors'=> $this->reply_form->getErrors(),
						'item'	=> $this->item_data
					));
				return $this;
			}

			return false;
		}




















	}














