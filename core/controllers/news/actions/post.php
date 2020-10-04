<?php

	namespace Core\Controllers\News\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\News\Config;
	use Core\Controllers\News\Controller;
	use Core\Controllers\News\Model;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

	class Post extends Controller{

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
		public $post;
		public $limit = 30;

		public $item_slug;
		public $user_id;
		public $post_data;

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
			$this->attachments_controller = AttachmentsController::getInstance();
		}

		public function methodGet($news_post_slug){
			$this->item_slug = $news_post_slug;
			$this->post_data = $this->model->getNewsPostBySlug($this->item_slug);

			if($this->post_data){
				$this->updateTotalViewsForPostItem($this->item_slug,$this->post_data['nw_user_id'],'nw_slug');

				$this->response->controller('news','item')
					->setArray(array(
						'post'	=> $this->post_data,
						'attachments'	=> $this->attachments_controller->getAttachmentsFromIDsList(fx_arr($this->post_data['nw_attachments_ids']),$this->user_id)
					));

				if($this->post_data['nw_comments_enabled']){
					Comments::add($this->limit,$this->offset)
						->controller('news')
						->action('item')
						->item_id($this->post_data['nw_id'])
						->paginate(array('news','post',$this->item_slug))
						->author($this->user_id)
						->receiver($this->post_data['nw_user_id'])
						->set();
				}

				return $this->setResponse();
			}

			return false;
		}

		public function setResponse(){
			$title = fx_crop_string($this->post_data['nw_title'],50);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setLink('news','post',$this->item_slug)
				->setValue($title)
				->setIcon(null);

			return $this;
		}



















	}














