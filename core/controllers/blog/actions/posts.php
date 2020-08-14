<?php

	namespace Core\Controllers\Blog\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Blog\Config;
	use Core\Controllers\Blog\Controller;
	use Core\Controllers\Blog\Model;
	use Core\Controllers\Users\Model as UserModel;

	class Posts extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
		public $model;
		public $user_model;

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
		public $posts;

		public $limit = 20;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $prepared_data = array();
		public $sorting_panel;
		public $posts_data;
		public $user_id;
		public $user_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "`b_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `b_public`=1";

			$this->user_model = UserModel::getInstance();
		}

		public function methodGet($user_id,$order='all',$sort='up'){
			$this->user_id = (int)$user_id;

			$this->sorting_action	= $order;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'up';

			$this->query .= " AND `b_user_id`={$this->user_id}";

			$this->total = $this->model->countAllPosts($this->query);

			$this->user_data = $this->user_model->getUserByID($this->user_id);
			$this->setResponse();

			$this->sorting_panel = $this->params->sorting_panel;
			$this->prepareSortingActions();
			$this->sorting($this->sorting_panel);

			$this->posts_data = $this->model->getAllPosts(
				$this->query,$this->limit,$this->offset,$this->order,$this->sort
			);

			$this->paginate($this->total, array('blog','posts',$this->user_id,$this->sorting_action,$this->sorting_type));

			$this->response->controller('blog','posts')
				->setArray(array(
					'posts'	=> $this->posts_data,
					'total'	=> $this->total,
					'user'	=> $this->user_data,
				));

			return $this;
		}

		public function prepareSortingActions(){
			foreach($this->sorting_panel as $key=>$value){
				$this->sorting_panel[$key]['link'] = array('blog','posts',$this->user_id,$value['link'][2]);
			}
			return $this;
		}

		public function setResponse(){
			if(!$this->user_data){ return $this; }

			$this->response->title($this->user_data['u_full_name']);
			$this->response->breadcrumb('by_user')
				->setLink('blog','posts',$this->user_id)
				->setValue($this->user_data['u_full_name'])
				->setIcon(null);

			return $this;
		}

		protected function setSortingPanelAll(){
			$this->order = 'b_id';
			return null;
		}

		protected function setSortingPanelCreated(){
			$this->order = 'b_date_created';
			return null;
		}

		protected function setSortingPanelUpdated(){
			$this->order = 'b_date_updated';
			return null;
		}

		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}



















	}














