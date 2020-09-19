<?php

	namespace Core\Controllers\Blog\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Blog\Config;
	use Core\Controllers\Blog\Controller;
	use Core\Controllers\Blog\Forms\Add_Post;
	use Core\Controllers\Blog\Model;
	use Core\Controllers\Categories\Controller as CatsController;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

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

		/** @var Add_Post */
		public $add_form;
		public $insert_data = array(
			'b_user_id'			=> '',
			'b_image_preview_id'=> '',
			'b_slug'			=> '',
			'b_category_id'		=> '',
			'b_title'			=> '',
			'b_content'			=> '',
			'b_date_created'	=> '',
			'b_comments_enabled'=> '',
			'b_public'			=> '',
		);

		public $image_id;
		public $title;
		public $content;
		public $comments_enabling;
		public $public_status;

		public $post_id;
		public $post_slug;
		public $user_id;

		public $category_id = 0;		// временно 0, пока нет категорий
		public $categories;				// список категорий
		public $cat_id;					// текущая категория
		public $cats_controller;

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

			$this->user_id = $this->user->getUID();
			$this->add_form = Add_Post::getInstance();
			$this->cats_controller = CatsController::getInstance();
			$this->cat_id = $this->cats_controller->getCurrentCategoryID();
			$this->categories = $this->cats_controller->setCategories('blog')
				->getCategories();
		}

		public function methodGet(){
			$this->add_form->setCategories($this->categories,$this->cat_id)
				->generateFieldsList();

			$this->response->controller('blog','add')
				->setArray(array(
					'form'		=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));

			return $this->setResponse();
		}

		public function methodPost(){
			$this->add_form->setCategories($this->categories,$this->cat_id)
				->checkFieldsList($this->request->getAll());

			$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
			$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
			$this->add_form->setParams('variants',array(
				'ids'	=> $this->attachments_ids,
				'data'	=> $this->attachments_data
			),'attachments');

			if($this->add_form->can()){

				$this->category_id = $this->add_form->getAttribute('b_category_id');
				$this->image_id = $this->add_form->getAttribute('b_image_preview_id');
				$this->content = $this->add_form->getAttribute('b_content');
				$this->title = $this->add_form->getAttribute('b_title');

				$this->public_status = $this->add_form->getAttribute('b_public');
				$this->comments_enabling = $this->add_form->getAttribute('b_comments_enabled');

				if(!$this->title){
					$this->title = fx_crop_string($this->content,191,null);
				}

				$this->insert_data['b_user_id'] 			= $this->user_id;
				$this->insert_data['b_image_preview_id']	= (int)$this->image_id;
				$this->insert_data['b_category_id']			= $this->category_id;
				$this->insert_data['b_title'] 				= $this->title;
				$this->insert_data['b_content']				= $this->content;
				$this->insert_data['b_date_created'] 		= time();
				$this->insert_data['b_comments_enabled'] 	= $this->comments_enabling ? 1 : 0;
				$this->insert_data['b_public'] 				= $this->public_status ? 1 : 0;
				$this->insert_data['b_attachments_ids'] 	= $this->attachments_ids ? $this->attachments_ids : null;

				$this->post_id = $this->model->addBlogPostItem($this->insert_data);

				if($this->post_id){
					$this->post_slug = $this->makeSlugFromString($this->post_id,$this->title);
					if($this->model->updatePostSlugById($this->post_id,$this->post_slug)){
						return $this->redirect(fx_get_url('blog','post',$this->post_slug));
					}
				}
			}

			$this->response->controller('blog','add')
				->setArray(array(
					'form'		=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));

			return $this->setResponse();
		}

		public function setResponse(){
			$this->response->title('blog.add_new_post_breadcrumb');
			$this->response->breadcrumb('add')
				->setValue('blog.add_new_post_breadcrumb')
				->setLink('blog','add')
				->setIcon(null);

			return $this;
		}















	}














