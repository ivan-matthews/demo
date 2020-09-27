<?php

	namespace Core\Controllers\Pages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Pages\Config;
	use Core\Controllers\Pages\Controller;
	use Core\Controllers\Pages\Model;
	use Core\Controllers\Categories\Controller as CatsController;

	class Index extends Controller{

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
		public $index;

		public $limit = 20;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $prepared_data = array();
		public $sorting_panel;
		public $posts_data;
		public $user_id;

		public $cats_controller;
		public $cat_id;

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
			$this->query .= "`pg_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `pg_public`=1";
			$this->cats_controller = CatsController::getInstance();
			$this->cat_id = $this->cats_controller->getCurrentCategoryID();
		}

		public function methodGet(){
			if($this->cat_id){
				$this->query .= " AND `pg_category_id`=%category_id%";
				$this->prepared_data['%category_id%'] = $this->cat_id;
			}

			$this->total = $this->model->countAllPosts($this->query,$this->prepared_data);

			$this->posts_data = $this->model->getAllPosts(
				$this->query,$this->limit,$this->offset,$this->prepared_data
			);

			$this->paginate($this->total, array('pages','index'));

			$this->response->controller('pages','index')
				->setArray(array(
					'posts'	=> $this->posts_data,
					'total'	=> $this->total
				));

			return $this;
		}

















	}














