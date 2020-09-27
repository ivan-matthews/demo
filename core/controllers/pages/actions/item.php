<?php

	namespace Core\Controllers\Pages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Pages\Config;
	use Core\Controllers\Pages\Controller;
	use Core\Controllers\Pages\Model;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

	class Item extends Controller{

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
		public $item;
		public $item_id;
		public $user_id;
		public $post_data;

		/** @var AttachmentsController */
		public $attachments_controller;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->user_id = $this->user->getUID();
		}

		public function methodGet($pages_post_id){
			$this->item_id = $pages_post_id;
			$this->post_data = $this->model->getBlogPostById($this->item_id);

			if($this->post_data){
				$this->updateTotalViewsForPostItem($this->item_id,$this->post_data['pg_user_id']);

				$this->response->controller('pages','item')
					->setArray(array(
						'post'	=> $this->post_data,
						'attachments'	=> $this->attachments_controller->getAttachmentsFromIDsList(fx_arr($this->post_data['pg_attachments_ids']))
					));

				if($this->post_data['pg_comments_enabled']){
					Comments::add($this->limit,$this->offset)
						->controller('pages')
						->action('item')
						->item_id($this->post_data['pg_id'])
						->paginate(array('pages','item',$this->item_id))
						->author($this->user_id)
						->receiver($this->post_data['pg_user_id'])
						->set();
				}

				return $this->setResponse();
			}

			return false;
		}

		public function setResponse(){
			$title = fx_crop_string($this->post_data['pg_title'],50);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setLink('pages','item',$this->post_data['pg_id'])
				->setValue($title)
				->setIcon(null);

			return $this;
		}





















	}














