<?php

	namespace Core\Controllers\Notify\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Mail\Notice;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Notify\Config;
	use Core\Controllers\Notify\Controller;
	use Core\Controllers\Notify\Model;

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

		public $limit = 15;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $user_id;
		public $sorting_panel;
		public $current_tab;

		public $notices_data;

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
			$this->query .= "n_status != " . Notice::STATUS_DELETED;
		}

		public function methodGet($current_tab='all'){
			if(!$this->user->logged()){ return false; }

			$this->current_tab = $current_tab;

			$this->sorting_panel = $this->params->sorting_panel;

			$this->setResponse();
			$this->prepareHeaderBarLinks();

			$this->header_bar($this->sorting_panel,array('notify','index'),$this->current_tab);

			$this->total = $this->model->countNotices($this->user_id,$this->query);

			if($this->total){
				$this->notices_data = $this->model->getNotices(
					$this->user_id,
					$this->query,
					$this->limit,
					$this->offset
				);

				$this->paginate($this->total, array('notify','index',$this->current_tab));

				$this->response->controller('notify','index')
					->setArray(array(
						'notices'	=> $this->notices_data,
						'total'		=> $this->total,
						'user'		=> $this->user_id,
					));
				return $this;
			}

			return $this->renderEmptyPage();
		}


		public function prepareHeaderBarLinks(){
			$callable_method = "setHeaderBar{$this->current_tab}";
			if(method_exists($this,$callable_method)){
				call_user_func(array($this,$callable_method));
			}
			return $this;
		}

		protected function setHeaderBarAll(){
			$this->response->title('notify.all_notices_sorting');
			$this->response->breadcrumb('all')
				->setLink('notify','index','all')
				->setValue('notify.all_notices_sorting')
				->setIcon(null);
			return $this;
		}
		protected function setHeaderBarReaded(){
			$this->response->title('notify.readed_notices_sorting');
			$this->response->breadcrumb('readed')
				->setLink('notify','index','readed')
				->setValue('notify.readed_notices_sorting')
				->setIcon(null);
			$this->query .= " AND n_status=" . Notice::STATUS_READED;
			return $this;
		}
		protected function setHeaderBarUnreaded(){
			$this->response->title('notify.unreaded_notices_sorting');
			$this->response->breadcrumb('unreaded')
				->setLink('notify','index','unreaded')
				->setValue('notify.unreaded_notices_sorting')
				->setIcon(null);
			$this->query .= " AND n_status=" . Notice::STATUS_UNREAD;
			return $this;
		}


		public function setResponse(){
			$this->response->title('notify.notices_title');
			$this->response->breadcrumb('notify')
				->setLink('notify','index')
				->setValue('notify.notices_title')
				->setIcon(null);

			return $this;
		}

















	}














