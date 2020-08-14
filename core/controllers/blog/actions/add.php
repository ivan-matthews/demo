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

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->add_form = Add_Post::getInstance();
		}

		public function methodGet(){
			if(!$this->user->logged()){ return false; }

			$this->add_form->generateFieldsList();

			$this->response->controller('blog','add')
				->setArray(array(
					'form'		=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));

			return $this->setResponse();
		}

		public function methodPost(){
			fx_die($this->request->getAll());
			return false;
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














