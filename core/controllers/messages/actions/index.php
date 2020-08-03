<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Model;

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

		public $limit = 10;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $user_id;
		public $contacts_list;

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
		}

		public function methodGet(){
			$this->setResponse();

			$this->total = $this->model->countContacts($this->user_id);

			if($this->total){

				$this->contacts_list = $this->model->getContacts($this->user_id,$this->limit,$this->offset);

				$this->paginate($this->total, array('messages','index'));

				$this->response->controller('messages','index')
					->setArray(array(
						'contacts'	=> $this->contacts_list,
						'total'		=> $this->total
					));
				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function setResponse(){
			$this->response->title('messages.messages_contacts_title');
			$this->response->breadcrumb('messages')
				->setValue('messages.messages_contacts_title')
				->setLink('messages','index')
				->setIcon(null);
			return $this;
		}




















	}














