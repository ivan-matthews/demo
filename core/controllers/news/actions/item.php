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

		public function methodGet($news_post_id){
			$this->item_id = $news_post_id;
			$this->post_data = $this->model->getNewsPostById($this->item_id);

			if($this->post_data){
				$this->updateTotalViewsForPostItem($this->item_id,$this->post_data['nw_user_id']);

				$this->response->controller('news','item')
					->setArray(array(
						'post'	=> $this->post_data,
						'attachments'	=> $this->attachments_controller->getAttachmentsFromIDsList(fx_arr($this->post_data['nw_attachments_ids']))
					));

				if($this->post_data['nw_comments_enabled']){
					Comments::add($this->limit,$this->offset)
						->controller('news')
						->action('item')
						->item_id($this->post_data['nw_id'])
						->paginate(array('news','item',$this->item_id))
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
				->setLink('news','item',$this->post_data['nw_id'])
				->setValue($title)
				->setIcon(null);

			return $this;
		}





















	}














