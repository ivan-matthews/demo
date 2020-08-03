<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;
	use Core\Controllers\Users\Model as UserModel;

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

		public $user_id;
		public $user_model;
		public $avatar_data;
		public $user_data;

		public $query = '';
		public $limit = 30;
		public $offset = 0;

		public $order;
		public $sort;

		public $sorting_action;
		public $sorting_type;
		public $sorting_panel;

		public $total_avatars;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->user_model = UserModel::getInstance();
			$this->query = "p_status != '" . Kernel::STATUS_BLOCKED. "'";
			$this->order = 'p_id';
		}

		public function methodGet($user_id,$sorting_action='all',$sort='up'){
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'up';

			$this->user_id = $user_id;

			$this->total_avatars = $this->model->countAllUserAvatars($this->user_id,$this->query);

			$this->user_data = $this->user_model->getUserByID($this->user_id);

			$this->setResponse($this->user_data);

			if($this->total_avatars && $this->user_data){

				$this->sorting_panel = $this->params->sorting_panel;
				$this->prepareSortingPanelLinks();
				$this->sorting($this->sorting_panel);

				$this->avatar_data = $this->model->getAllUserAvatars(
					$this->user_id,$this->limit,$this->offset,$this->query,$this->order,$this->sort
				);

				$this->paginate($this->total_avatars, array('avatar','index',$this->user_id));

				$this->response->controller('avatar','index')
					->setArray(array(
						'user'		=> $this->user_data,
						'avatars'	=> $this->avatar_data
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function prepareSortingPanelLinks(){
			foreach($this->sorting_panel as $sorting_key=>$sorting_value){
				$this->sorting_panel[$sorting_key]['link'][2] = $this->user_id;
			}
			return $this;
		}

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelCreated(){
			$this->order = 'p_date_created';
			return null;
		}
		protected function setSortingPanelUpdated(){
			$this->order = 'p_date_updated';
			return null;
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}



















	}














