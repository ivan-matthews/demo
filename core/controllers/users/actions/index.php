<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Forms\Filter;
	use Core\Controllers\Users\Model;
	use Core\Classes\Kernel;

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
		public $users;

		public $filter;
		public $fields;

		public $limit = 10;
		public $offset = 0;

		public $sorting_action;
		public $sorting_type;

		public $total_users;
		public $all_users_data;

		public $users_menu = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->filter = Filter::getInstance();
			$this->query = "u_status = '" . Kernel::STATUS_ACTIVE. "'";
			$this->order = 'u_id';

			$this->language_key = $this->language->getLanguageKey();

			$this->model->users_index_fields[] = "gc_title_{$this->language_key} as city";
			$this->model->users_index_fields[] = "gc_area as area";
			$this->model->users_index_fields[] = "g_title_{$this->language_key} as country";
			$this->model->users_index_fields[] = "gr_title_{$this->language_key} as region";
		}

		public function methodGet($sorting_action='all',$sort='up'){
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$link = array('users', 'index', $this->sorting_action, $this->sorting_type);

			$this->fields = $this->params->loadParamsFromControllerFile('fields');

			$this->filter->filter(fx_get_url(...$link), $this->fields);
			$this->sorting($this->params->sorting_panel);

			$this->query .= $this->filter->getQuery();
			$replacing_data = $this->filter->getReplacingData();

			$this->total_users = $this->model->countAllUsers(
				$this->query,$replacing_data
			);
			$this->all_users_data = $this->model->getAllUsers(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,$replacing_data
			);

			$this->paginate($this->total_users, $link);

			if($this->all_users_data){
				return $this->response->controller('users','index')
					->set('users',$this->all_users_data);
			}

			return false;
		}



/*		SORTING PANEL ACTIONS			*/

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelAvatar(){
			return " AND !isnull(u_avatar_id)";
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			$this->sort = 'ASC';
			return null;
		}
		protected function setSortingPanelOnline(){
			$this->order = '`u_date_log`';
			return " AND `u_date_log`>" . time();
		}
		protected function setSortingPanelRegistration(){
			$this->order = '`u_date_created`';
			return null;
		}
		protected function setSortingPanelLast_visit(){
			$this->order = '`u_date_log`';
			return " AND `u_date_log`<" . time();
		}
		protected function setSortingPanelActive(){
			return " AND `u_status`=" . Kernel::STATUS_ACTIVE;
		}
		protected function setSortingPanelInactive(){
			return " AND `u_status`=" . Kernel::STATUS_INACTIVE;
		}
		protected function setSortingPanelLocked(){
			return " AND `u_status`=" . Kernel::STATUS_LOCKED;
		}



















	}














