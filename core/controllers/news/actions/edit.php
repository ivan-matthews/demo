<?php

	namespace Core\Controllers\News\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\News\Config;
	use Core\Controllers\News\Controller;
	use Core\Controllers\News\Model;
	use Core\Controllers\News\Forms\Edit_Post;
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
			'nw_image_preview_id'	=> '',
			'nw_category_id'			=> '',
			'nw_title'				=> '',
			'nw_content'				=> '',
			'nw_date_updated'		=> '',
			'nw_comments_enabled'	=> '',
			'nw_public'				=> '',
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
			$this->categories = $this->cats_controller->setCategories('news')
				->getCategories();
		}

		public function methodGet($post_id){
			$this->post_id = $post_id;
			$this->post_info = $this->model->getNewsPostById($this->post_id,'p_medium');

			if($this->post_info && fx_me($this->post_info['nw_user_id'])){

				$this->edit_form->setCategories($this->cats_controller->getCategories(),$this->cat_id)
					->setData($this->post_info);
				$this->edit_form->generateFieldsList($this->post_id);

				$this->attachments_ids = fx_arr($this->post_info['nw_attachments_ids']);
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				$this->request->set('preview_image',$this->post_info['medium_news_image']);

				$this->response->controller('news','edit')
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
			$this->post_info = $this->model->getNewsPostById($this->post_id);

			if($this->post_info && fx_me($this->post_info['nw_user_id'])){

				$this->post_slug = $this->post_info['nw_slug'];

				$this->edit_form->setCategories($this->categories,$this->cat_id)
					->checkFieldsList($this->request->getAll(),$this->post_id);

				$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
				$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->user_id);
				$this->edit_form->setParams('variants',array(
					'ids'	=> $this->attachments_ids,
					'data'	=> $this->attachments_data
				),'attachments');

				if($this->edit_form->can()){
					$this->category_id = $this->edit_form->getAttribute('nw_category_id');
					$this->image_id = $this->edit_form->getAttribute('nw_image_preview_id');
					$this->content = $this->edit_form->getAttribute('nw_content');
					$this->title = $this->edit_form->getAttribute('nw_title');

					$this->public_status = $this->edit_form->getAttribute('nw_public');
					$this->comments_enabling = $this->edit_form->getAttribute('nw_comments_enabled');

					if(!$this->title){
						$this->title = fx_crop_string($this->content,191,null);
					}

					$this->update_data['nw_image_preview_id']	= (int)$this->image_id;
					$this->update_data['nw_category_id']			= $this->category_id;
					$this->update_data['nw_title'] 				= $this->title;
					$this->update_data['nw_content']				= $this->content;
					$this->update_data['nw_date_updated'] 		= time();
					$this->update_data['nw_comments_enabled'] 	= $this->comments_enabling ? '1' : '0';
					$this->update_data['nw_public'] 				= $this->public_status ? '1' : '0';
					$this->update_data['nw_attachments_ids'] 	= $this->attachments_ids ? $this->attachments_ids : null;

					if($this->model->editNewsPostItem($this->update_data,$this->post_id)){
						return $this->redirect(fx_get_url('news','post',$this->post_slug));
					}
				}

				$this->response->controller('news','edit')
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
				$title = fx_crop_string($this->post_info['nw_title'],30);
				$this->response->title($title);
				$this->response->breadcrumb('item')
					->setValue($title)
					->setLink('news','post',$this->post_info['nw_slug'])
					->setIcon(null);
			}

			$this->response->title('news.edit_new_post_breadcrumb');
			$this->response->breadcrumb('edit')
				->setValue('news.edit_new_post_breadcrumb')
				->setLink('news','edit',$this->post_id)
				->setIcon(null);

			return $this;
		}

		// в AttachmentsController

















	}














