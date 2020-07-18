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
		public $config;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $site_config;

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
		public $order;
		public $sort;

		public $ordering = array(
			'create'	=> 'date_created',
			'logged'	=> 'date_log',
		);

		public $filter_desired_values = array(
			'all'	=> array(
				'title'	=> 'users.users_index_all_title',
				'link'	=> array('users','index'),
			),
			'online'	=> array(
				'title'	=> 'users.users_index_online_title',
				'link'	=> array('users','index','online')
			),
			'offline'	=> array(
				'title'	=> 'users.users_index_offline_title',
				'link'	=> array('users','index','offline')
			),
			'active'	=> array(
				'title'	=> 'users.users_index_active_title',
				'link'	=> array('users','index','active')
			),
			'inactive'	=> array(
				'title'	=> 'users.users_index_inactive_title',
				'link'	=> array('users','index','inactive')
			),
			'locked'	=> array(
				'title'	=> 'users.users_index_locked_title',
				'link'	=> array('users','index','locked')
			),
		);

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->response->title('users.users_index_title');
			$this->response->breadcrumb('users')
				->setIcon(null)
				->setLink('users','index')
				->setValue('users.users_index_title');

			$this->query	= "`status`!=" . Kernel::STATUS_BLOCKED;
		}

		public function methodGet($filter_suffix=null){
			$this->order	= isset($this->ordering[$this->order]) ? $this->ordering[$this->order] : 'id';
			$this->sort		= isset($this->sorting[$this->sort]) ? $this->sorting[$this->sort] : 'ASC';

			if(isset($this->filter_desired_values[$filter_suffix]) && method_exists($this,$filter_suffix)){
				$this->query .= call_user_func(array($this,$filter_suffix));
			}

			$this->total = $this->users = $this->model->countAllUsers($this->query);
			$this->users = $this->model->getAllUsers(
				$this->limit, $this->offset, $this->query, $this->order, $this->sort
			);

			$this->paginate(array('users','index',$filter_suffix));
			$this->sorting($this->filter_desired_values,$filter_suffix);

			if($this->users){
				return $this->response->controller('users','index')
					->set('users',$this->users);
			}
			return $this->renderEmptyPage();
		}


		private function online(){
			$this->response->title('users.users_index_online_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','online')
				->setValue('users.users_index_online_title');

			return " AND `date_log`>" . time();
		}
		private function offline(){
			$this->response->title('users.users_index_online_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','offline')
				->setValue('users.users_index_online_title');

			return " AND `date_log`<" . time();
		}
		private function active(){
			$this->response->title('users.users_index_active_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','active')
				->setValue('users.users_index_active_title');

			return " AND `status`=" . Kernel::STATUS_ACTIVE;
		}
		private function inactive(){
			$this->response->title('users.users_index_inactive_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','inactive')
				->setValue('users.users_index_inactive_title');

			return " AND `status`=" . Kernel::STATUS_INACTIVE;
		}
		private function locked(){
			$this->response->title('users.users_index_locked_title');
			$this->response->breadcrumb('filter')
				->setIcon(null)
				->setLink('users','index','locked')
				->setValue('users.users_index_locked_title');

			return " AND `status`=" . Kernel::STATUS_LOCKED;
		}

















	}














