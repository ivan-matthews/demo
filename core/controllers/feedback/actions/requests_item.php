<?php

	namespace Core\Controllers\Feedback\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Feedback\Config;
	use Core\Controllers\Feedback\Controller;
	use Core\Controllers\Feedback\Model;
	use Core\Classes\Kernel;

	class Requests_Item extends Controller{

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
		public $requests_item;


		public $limit = 20;
		public $offset;
		public $total;
		public $sort;

		public $prepared_data = array();
		public $sorting_panel;
		public $contacts_mail;
		public $bids_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "`fb_status` != " . Kernel::STATUS_BLOCKED;
			$this->sorting_panel = $this->params->sorting_panel;
		}

		public function methodGet($contacts_mail,$order='all'){
			$this->sorting_action	= $order;
			$this->contacts_mail = $contacts_mail;
			$this->query .= " AND fb_email=%fb_email%";
			$this->prepared_data['%fb_email%'] = $this->contacts_mail;

			$this->total = $this->model->countFeedbackItems($this->query,$this->prepared_data);

			$this->prepareHeaderBarLinks();

			$this->header_bar($this->sorting_panel,array('feedback','requests_item',$this->contacts_mail),$this->sorting_action);

			$this->bids_data = $this->model->getFeedbackItems(
				$this->query,
				$this->prepared_data,
				$this->limit,
				$this->offset
			);
			if($this->bids_data){
				$this->paginate($this->total, array('feedback','requests_item',$this->contacts_mail,$this->sorting_action));

				$this->setResponse();
				$this->addRequestsResponse();
				if(isset($this->bids_data[0]['fb_email'])){
					$this->addRequestsItemResponse($this->bids_data[0]['fb_email']);
				}

				$this->response->controller('feedback','requests_item')
					->setArray(array(
						'bids'	=> $this->bids_data,
						'total'	=> $this->total
					));

				return $this;
			}
			return $this->renderEmptyPage();
		}

		public function prepareHeaderBarLinks(){
			$callable_method = "setHeaderBar{$this->sorting_action}";
			if(method_exists($this,$callable_method)){
				call_user_func(array($this,$callable_method));
			}
			return $this;
		}

		protected function setHeaderBarAll(){
			$this->query .= " AND fb_status != " . Kernel::STATUS_DELETED;
			$this->query .= " AND fb_status != " . Kernel::STATUS_BLOCKED;
			return null;
		}

		protected function setHeaderBarNew(){
			$this->query .= " AND fb_status = " . Kernel::STATUS_ACTIVE;
			return null;
		}

		protected function setHeaderBarOld(){
			$this->query .= " AND fb_status = " . Kernel::STATUS_INACTIVE;
			return null;
		}



















	}














