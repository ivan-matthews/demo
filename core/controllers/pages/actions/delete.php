<?php

	namespace Core\Controllers\Pages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Pages\Config;
	use Core\Controllers\Pages\Controller;
	use Core\Controllers\Pages\Model;

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

		public $post_id;
		public $post_data;
		public $user_id;
		public $update_result;

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
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($post_id){
			$this->post_id = $post_id;

			$this->post_data = $this->model->getBlogPostById($this->post_id);

			if($this->post_data){

				if(!fx_me($this->post_data['pg_user_id'])){ return false; }

				$this->update_result = $this->model->deleteBlogPostItemById($this->post_id);

				if($this->update_result){
					return $this->redirect(fx_get_url('pages','index'));
				}

			}

			return false;
		}





















	}














