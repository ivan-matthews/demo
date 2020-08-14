<?php

	namespace Core\Controllers\Comments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Mail\Notice;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Config;
	use Core\Controllers\Comments\Controller;
	use Core\Controllers\Comments\Forms\Add_Comment;
	use Core\Controllers\Comments\Model;

	class Add extends Controller{

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
		public $add;

		public $sender_id;
		public $receiver_id;
		public $controller;
		public $action = null;
		public $item_id;

		public $send_form;
		public $comment_id;
		public $comment_content;

		public $content_item;
		public $back_url;

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

			$this->back_url = $this->user->getBackUrl();

			$this->send_form = Add_Comment::getInstance();
			$this->sender_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($controller,$action,$item_id,$receiver_id){
			$this->controller = $controller;
			$this->action = $action;
			$this->item_id = $item_id;
			$this->receiver_id = $receiver_id;

			if(!$this->checkAllowedController()){ return false; }

			$this->send_form->generateFieldsList($this->controller, $this->action, $this->item_id, $this->receiver_id);

			$this->setResponse();

			$this->response->controller('comments','add')
				->setArray(array(
					'form'		=> $this->send_form->getFormAttributes(),
					'fields'	=> $this->send_form->getFieldsList(),
					'errors'	=> $this->send_form->getErrors(),
				));

			return $this;
		}

		public function methodPost($controller,$action,$item_id,$receiver_id){
			$this->controller = $controller;
			$this->action = $action;
			$this->item_id = $item_id;
			$this->receiver_id = $receiver_id;

			if(!$this->checkAllowedController()){ return false; }

			$this->send_form->setData($this->request->getAll());
			$this->send_form->checkFieldsList($this->controller, $this->action, $this->item_id, $this->receiver_id);

			$this->setResponse();

			if($this->send_form->can()){
				$this->comment_content = $this->send_form->getAttribute('comment','value');

				$this->comment_id = $this->model->addComment(
					$this->controller,
					$this->action,
					$this->item_id,
					$this->sender_id,
					$this->comment_content
				);
				if($this->comment_id){
					$this->model->updateTotalComments(
						$this->params->allowed_controllers[$this->controller]['table_name'],
						$this->params->allowed_controllers[$this->controller]['count_field'],
						$this->params->allowed_controllers[$this->controller]['id_field'],
						$this->item_id,
						"{$this->params->allowed_controllers[$this->controller]['count_field']}+1"
					);

					return $this->sendNotice()->redirect("{$this->back_url}#{$this->comments_list_id}");
				}
			}

			$this->response->controller('comments','add')
				->setArray(array(
					'form'		=> $this->send_form->getFormAttributes(),
					'fields'	=> $this->send_form->getFieldsList(),
					'errors'	=> $this->send_form->getErrors(),
				));

			return $this;
		}

		public function setResponse(){
			$this->response->title('comments.comments_controller_title');
			$this->response->breadcrumb('comment')
				->setValue('comments.comments_controller_title')
				->setLink('comments','add',$this->controller,$this->action,$this->item_id)
				->setIcon(null);
			return $this;
		}

		public function sendNotice(){
			if(fx_me($this->receiver_id)){ return $this; }

			Notice::ready()
				->theme('comments.send_notice_title')
				->sender($this->sender_id)
				->manager(Notice::MANAGER_SYSTEM)
				->receiver($this->receiver_id)
				->action($this->controller,$this->action,$this->item_id)
				->key("{$this->controller}.{$this->action}.{$this->item_id}")
				->content(fx_crop_string($this->comment_content,50))
				->create()
				->send();

			return $this;
		}


















	}














