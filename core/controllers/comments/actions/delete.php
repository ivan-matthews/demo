<?php

	namespace Core\Controllers\Comments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Config;
	use Core\Controllers\Comments\Controller;
	use Core\Controllers\Comments\Model;

	class Delete extends Controller{

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
		public $delete;

		public $sender_id;

		public $controller;
		public $action = null;
		public $item_id;

		public $comment_id;
		public $comment_item;

		public $delete_comment;
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

			$this->back_url = $this->user->getBackUrl();

			$this->backLink();
			$this->sender_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($controller,$action,$item_id,$comment_id){
			$this->controller = $controller;
			$this->action = $action;
			$this->item_id = $item_id;

			$this->comment_id = $comment_id;

			$this->comment_item = $this->model->getCommentById($this->comment_id);

			if($this->comment_item && fx_me($this->comment_item['c_author_id'])){
				$this->delete_comment = $this->model->deleteComment($this->comment_id);
				if($this->delete_comment){
					$this->model->updateTotalComments(
						$this->params->allowed_controllers[$this->controller]['table_name'],
						$this->params->allowed_controllers[$this->controller]['count_field'],
						$this->params->allowed_controllers[$this->controller]['id_field'],
						$this->item_id,
						"{$this->params->allowed_controllers[$this->controller]['count_field']}-1"
					);
					return $this->redirect("{$this->back_url}#{$this->comments_list_id}");
				}
			}

			return false;
		}




















	}














