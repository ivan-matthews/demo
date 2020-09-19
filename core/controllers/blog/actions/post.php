<?php

	namespace Core\Controllers\Blog\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Blog\Config;
	use Core\Controllers\Blog\Controller;
	use Core\Controllers\Blog\Model;
	use Core\Controllers\Comments\Widgets\Comments;

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

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($blog_post_slug){
			$this->item_slug = $blog_post_slug;
			$this->post_data = $this->model->getBlogPostBySlug($this->item_slug);

			if($this->post_data){
				$this->updateTotalViewsForPostItem($this->item_slug,$this->post_data['b_user_id'],'b_slug');

				$this->response->controller('blog','item')
					->setArray(array(
						'post'	=> $this->post_data
					));

				if($this->post_data['b_comments_enabled']){
					Comments::add($this->limit,$this->offset)
						->controller('blog')
						->action('item')
						->item_id($this->post_data['b_id'])
						->paginate(array('blog','post',$this->item_slug))
						->author($this->user_id)
						->receiver($this->post_data['b_user_id'])
						->set();
				}

				return $this->setResponse();
			}

			return false;
		}

		public function setResponse(){
			$title = fx_crop_string($this->post_data['b_title'],50);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setLink('blog','post',$this->item_slug)
				->setValue($title)
				->setIcon(null);

			return $this;
		}



















	}














