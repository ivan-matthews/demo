<?php

	namespace Core\Controllers\Pages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Pages\Config;
	use Core\Controllers\Pages\Controller;
	use Core\Controllers\Pages\Model;
	use Core\Controllers\Pages\Forms\Edit_Post;
	use Core\Controllers\Attachments\Controller as AttachmentsController;
	use Core\Controllers\Categories\Controller as CatsController;

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

		/** @var Edit_Post */
		public $edit_form;
		public $update_data = array(
			'pg_image_preview_id'	=> '',
			'pg_category_id'			=> '',
			'pg_title'				=> '',
			'pg_content'				=> '',
			'pg_date_updated'		=> '',
			'pg_comments_enabled'	=> '',
			'pg_public'				=> '',
		);

		public $image_id;
		public $title;
		public $content;
		public $comments_enabling;
		public $public_status;

		public $post_info;

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
			$this->edit_form = Edit_Post::getInstance();
			$this->cats_controller = CatsController::getInstance();
			$this->cat_id = $this->cats_controller->getCurrentCategoryID();
			$this->categories = $this->cats_controller->setCategories('pages')
				->getCategories();
		}

		public function methodGet($post_id){
			$this->post_id = $post_id;
			$this->post_info = $this->model->getBlogPostById($this->post_id,'p_medium');

			if($this->post_info && fx_me($this->post_info['pg_user_id'])){

				$this->edit_form->setCategories($this->cats_controller->getCategories(),$this->cat_id)
					->setData($this->post_info);
				$this->edit_form->generateFieldsList($this->post_id);

				$this->attachments_ids = fx_arr($this->post_info['pg_attachments_ids']);
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				$this->request->set('preview_image',$this->post_info['pages_image']);

				$this->response->controller('pages','edit')
					->setArray(array(
						'form'		=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors()
					));

				return $this->setResponse();
			}

			return false;
		}

		public function methodPost($post_id){

			$this->post_id = $post_id;
			$this->post_info = $this->model->getBlogPostById($this->post_id);

			if($this->post_info && fx_me($this->post_info['pg_user_id'])){

				$this->post_slug = $this->post_info['pg_slug'];

				$this->edit_form->setCategories($this->categories,$this->cat_id)
					->checkFieldsList($this->request->getAll(),$this->post_id);

				$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				if($this->edit_form->can()){
					$this->category_id = $this->edit_form->getAttribute('pg_category_id');
					$this->image_id = $this->edit_form->getAttribute('pg_image_preview_id');
					$this->content = $this->edit_form->getAttribute('pg_content');
					$this->title = $this->edit_form->getAttribute('pg_title');

					$this->public_status = $this->edit_form->getAttribute('pg_public');
					$this->comments_enabling = $this->edit_form->getAttribute('pg_comments_enabled');

					if(!$this->title){
						$this->title = fx_crop_string($this->content,191,null);
					}

					$this->update_data['pg_image_preview_id']	= (int)$this->image_id;
					$this->update_data['pg_category_id']			= $this->category_id;
					$this->update_data['pg_title'] 				= $this->title;
					$this->update_data['pg_content']				= $this->content;
					$this->update_data['pg_date_updated'] 		= time();
					$this->update_data['pg_comments_enabled'] 	= $this->comments_enabling ? '1' : '0';
					$this->update_data['pg_public'] 				= $this->public_status ? '1' : '0';
					$this->update_data['pg_attachments_ids'] 	= $this->attachments_ids ? $this->attachments_ids : null;

					if($this->model->editBlogPostItem($this->update_data,$this->post_id)){
						return $this->redirect(fx_get_url('pages','post',$this->post_slug));
					}
				}

				$this->response->controller('pages','edit')
					->setArray(array(
						'form'		=> $this->edit_form->getFormAttributes(),
						'fields'	=> $this->edit_form->getFieldsList(),
						'errors'	=> $this->edit_form->getErrors()
					));

				return $this->setResponse();
			}

			return false;
		}

		public function setResponse(){
			if($this->post_info){
				$title = fx_crop_string($this->post_info['pg_title'],30);
				$this->response->title($title);
				$this->response->breadcrumb('item')
					->setValue($title)
					->setLink('pages','post',$this->post_info['pg_slug'])
					->setIcon(null);
			}

			$this->response->title('pages.edit_new_post_breadcrumb');
			$this->response->breadcrumb('edit')
				->setValue('pages.edit_new_post_breadcrumb')
				->setLink('pages','edit',$this->post_id)
				->setIcon(null);

			return $this;
		}

		// в AttachmentsController

















	}














