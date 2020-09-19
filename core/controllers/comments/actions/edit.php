<?php

	namespace Core\Controllers\Comments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Config;
	use Core\Controllers\Comments\Controller;
	use Core\Controllers\Comments\Forms\Edit_Comment;
	use Core\Controllers\Comments\Model;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

	class Edit extends Controller{

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
		public $edit;

		public $sender_id;
		public $back_url;

		public $comment_id;
		public $comment_content;
		public $comment_data;

		public $edit_form;

		/** @var AttachmentsController */
		public $attachments_controller;
		public $attachments_ids;
		public $attachments_data;


		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->edit_form = Edit_Comment::getInstance();

			$this->back_url = $this->user->getBackUrl();
			$this->backLink();
			$this->sender_id = $this->user->getUID();
		}

		public function methodGet($comment_id){
			$this->comment_id = $comment_id;

			$this->comment_data = $this->model->getCommentById($this->comment_id);

			if($this->comment_data && fx_me($this->comment_data['c_author_id'])){
				$this->edit_form->setData(array(
					'comment'	=> $this->comment_data['c_content']
				));
				$this->edit_form->generateFieldsList($this->comment_id);

				$this->setResponse();

				$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->sender_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				$this->response->controller('comments','add')
					->setArray(array(
						'form'		=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
					));

				return $this;
			}

			return false;
		}

		public function methodPost($comment_id){
			$this->comment_id = $comment_id;

			$this->comment_data = $this->model->getCommentById($this->comment_id);

			if($this->comment_data && fx_me($this->comment_data['c_author_id'])){
				$this->edit_form->setData($this->request->getAll());
				$this->edit_form->checkFieldsList($this->comment_id);

				$this->setResponse();

				$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->sender_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				if($this->edit_form->can()){
					$this->comment_content = $this->edit_form->getAttribute('comment','value');
					if($this->model->updateCommentContent($this->comment_id,$this->comment_content,$this->attachments_ids)){
						return $this->redirect("{$this->back_url}#{$this->comments_list_id}");
					}
				}

				$this->response->controller('comments','add')
					->setArray(array(
						'form'		=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors(),
					));

				return $this;
			}

			return false;
		}

		public function setResponse(){
			$this->response->title('comments.comments_controller_title');
			$this->response->breadcrumb('comment')
				->setValue('comments.comments_controller_title')
				->setLink('comments','edit',$this->comment_id)
				->setIcon(null);
			return $this;
		}



















	}














