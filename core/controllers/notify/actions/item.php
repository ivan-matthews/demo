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

	class Item extends Controller{

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
		public $item_id;
		public $user_id;

		public $action_obj;
		public $action_class;

		public $called_action;
		public $called_url;
		public $called_controller;
		public $called_params;


		public $notice_data;

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

		public function methodGet($item_id){
			if(!$this->user->logged()){ return false; }

			$this->item_id = $item_id;

			$this->notice_data = $this->model->getNoticeById($this->item_id);

			if($this->notice_data && $this->notice_data['n_action']){
				$this->getActionObject();
				if(fx_equal((int)$this->notice_data['n_status'],Notice::STATUS_UNREAD)){
					$this->model->readNotice($this->item_id);
				}
				return call_user_func(array($this->action_obj,"methodGet"),...$this->called_params[0]);
			}

			return false;
		}

		public function getActionObject(){
			$this->called_url = fx_arr($this->notice_data['n_action']);
			$this->called_controller = $this->called_url[0];
			$this->called_action = $this->called_url[1];
			$this->called_params = array_slice($this->called_url,2);

			$this->action_class = "\\Core\\Controllers\\{$this->called_controller}\\Actions\\{$this->called_action}";
			$this->action_obj = call_user_func(array($this->action_class,'getInstance'));
			return $this;
		}
















	}














