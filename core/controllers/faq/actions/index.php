<?php

	namespace Core\Controllers\Faq\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Faq\Config;
	use Core\Controllers\Faq\Controller;
	use Core\Controllers\Faq\Model;

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

		public $limit = 50;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $faq_items;
		public $prepared_data = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->query = "f_status = " . Kernel::STATUS_ACTIVE;
		}

		public function methodGet(){
			if($this->cat_id){
				$this->query .= " AND `f_category_id`=%category_id%";
				$this->prepared_data['%category_id%'] = $this->cat_id;
			}

			$this->total = $this->model->countItems($this->query,$this->prepared_data);

			$this->setResponse();

			$this->faq_items = $this->model->getItems($this->query,$this->prepared_data,$this->limit,$this->offset);
			$this->paginate($this->total,array('faq','index'));

			$this->setMenuLinks();

			$this->response->controller('faq','index')
				->setArray(array(
					'items'	=> $this->faq_items,
					'total'	=> $this->total,
					'menu'	=> $this->menu,
				));

			return $this;
		}




















	}














