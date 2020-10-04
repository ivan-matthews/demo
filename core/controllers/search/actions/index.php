<?php

	namespace Core\Controllers\Search\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Search\Config;
	use Core\Controllers\Search\Controller;
	use Core\Controllers\Search\Model;

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

		public $limit = 30;
		public $offset = 0;
		public $total;
		public $order;
		public $sort;

		public $total_finds = array();

		public $search_key = 'find';

		public $search_query;
		public $current_controller;
		public $header_bar = array();
		public $search_result = array();

		public $default_fields = array(
			'image'			=> null,
			'date'			=> null,
			'title'			=> null,
			'link'			=> null,
			'description'	=> null,
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

			$this->search_query = $this->request->get($this->search_key);
		}

		public function methodGet($current_controller=null){
			$this->current_controller = $current_controller ? $current_controller : $this->params->default_controller;

			$this->header_bar = $this->params->header_bar;

			$this->hook->run('search');

			if(count($this->header_bar) > 1){
				$this->header_bar($this->header_bar,array('search','index'),$this->current_controller);
			}

			$this->total = isset($this->total_finds[$this->current_controller]) ? $this->total_finds[$this->current_controller] : 0;

			if($this->total){
				$this->paginate($this->total,array('search','index',$this->current_controller));

				$this->setResponse();

				$this->response->controller('search')
					->setArray(array(
						'total'			=> $this->total,
						'result'		=> $this->search_result,
						'controller'	=> $this->current_controller,
						'query'			=> $this->search_query
					));

				return $this;
			}
			return $this->renderEmptyPage();
		}

		public function setResponse(){
			$this->response->title('search.search_index_title');
			$this->response->breadcrumb('search')
				->setIcon(null)
				->setLink('search','index')
				->setValue('search.search_index_title');

			if(!isset($this->header_bar[$this->current_controller])){
				return $this;
			}

			$this->response->title($this->header_bar[$this->current_controller]['title']);
			$this->response->breadcrumb('search_action')
				->setIcon(null)
				->setLink('search','index',$this->current_controller)
				->setValue($this->header_bar[$this->current_controller]['title']);

			if($this->search_query){
				$this->response->title($this->search_query);
				$this->response->breadcrumb('search_query')
					->setIcon(null)
					->setLink(trim(fx_make_url(array('search','index',$this->current_controller),array($this->search_key => $this->search_query)),'/'))
					->setValue($this->search_query);
			}

			return $this;
		}



















	}














