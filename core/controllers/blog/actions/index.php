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
			$this->query .= "`b_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `b_public`=1";
		}

		public function methodGet($order='all',$sort='up'){
			$this->sorting_action	= $order;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'up';

			$this->setResponse();

			$this->total = $this->model->countAllPosts($this->query);

			if($this->total){

				$this->sorting_panel = $this->params->sorting_panel;
				$this->sorting($this->sorting_panel);

				$this->posts_data = $this->model->getAllPosts(
					$this->query,$this->limit,$this->offset,$this->order,$this->sort
				);

				$this->paginate($this->total, array('blog','index',$this->sorting_action,$this->sorting_type));

				$this->response->controller('blog','index')
					->setArray(array(
						'posts'	=> $this->posts_data,
						'total'	=> $this->total
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function setResponse(){
			$this->response->title($this->params->controller_name);
			$this->response->breadcrumb('blog')
				->setLink('blog','index')
				->setValue($this->params->controller_name)
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














