<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;

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

		public $query;
		public $limit;
		public $offset;
		public $total;
		public $sort;
		public $order = 'u_id';

		public $fields;

		protected $sorting_action;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query	= "u_status!=" . Kernel::STATUS_BLOCKED;
		}

		public function methodGet($sorting_action='all',$sort='up'){

	//-------------------------------------------------------------------------------------//

			//установить сортировку
			$this->setSortingProps($sorting_action,$sort);

			// получить массив полей для фильтрации
			$this->fields = $this->params->getParams('fields');

			// установить фильтр-панель; установить заапрос в БД для фильтрации
			$this->setFilterFromArrayFields('filter',$this->fields);

			// получить запрос для фильтрации; переменные для препарации
			$this->getQueryFromSortingPanelArray($this->params->sorting_panel,$this->sorting_action);

	//-------------------------------------------------------------------------------------//

			$this->total = $this->model->countAllUsers($this->query,$this->replaced_data);
			$this->users = $this->model->getAllUsers(
				$this->limit, $this->offset, $this->query, $this->order, $this->sort,$this->replaced_data
			);

			$this->paginate(array('users','index',$this->sorting_action,$this->sort_key));
			$this->sorting($this->params->sorting_panel,$this->sorting_action);

			if($this->users){
				return $this->response->controller('users','index')
					->set('users',$this->users);
			}
			return $this->renderEmptyPage();
		}

		protected function all(){
			return null;
		}
		protected function online(){
			$this->response->title('users.users_index_online_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','online')
				->setValue('users.users_index_online_title');
			$this->order = '`u_date_log`';
			return " AND `u_date_log`>" . time();
		}
		protected function registration(){
			$this->response->title('users.users_index_registration_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','registration')
				->setValue('users.users_index_registration_title');
			$this->order = '`u_date_created`';
			return null;
		}
		protected function offline(){
			$this->response->title('users.users_index_offline_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','offline')
				->setValue('users.users_index_offline_title');
			$this->order = '`u_date_log`';
			return " AND `u_date_log`<" . time();
		}
		protected function active(){
			$this->response->title('users.users_index_active_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','active')
				->setValue('users.users_index_active_title');

			return " AND `u_status`=" . Kernel::STATUS_ACTIVE;
		}
		protected function inactive(){
			$this->response->title('users.users_index_inactive_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','inactive')
				->setValue('users.users_index_inactive_title');

			return " AND `u_status`=" . Kernel::STATUS_INACTIVE;
		}
		protected function locked(){
			$this->response->title('users.users_index_locked_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','locked')
				->setValue('users.users_index_locked_title');

			return " AND `u_status`=" . Kernel::STATUS_LOCKED;
		}

















	}














