<?php

	namespace Core\Controllers\Search\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
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

		public $table;

		public $current_action;
		public $search_fields;

		public $search_query;
		public $search_result;
		public $search_total;

		public $preparing_data = array();

		public $limit = 15;
		public $offset;
		public $total;
		public $order;
		public $sort;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->search_query = $this->request->get('find');
		}

		public function methodGet($current_action='users'){
			$this->current_action = $current_action;

			if(isset($this->params->header_bar[$this->current_action])){

				if(count($this->params->header_bar) > 1){
					$this->header_bar($this->params->header_bar,array('search','index'),$this->current_action);
				}

				$this->makeQueryFromFields($this->params->header_bar,$this->current_action);

				$this->search_total = $this->model->count($this->table,$this->query,$this->preparing_data);

				$this->search_result = $this->model->find(
					$this->table,
					$this->query,
					$this->params->header_bar[$this->current_action]['fields'],
					$this->preparing_data,
					$this->order,
					$this->limit,
					$this->offset
				);

				$this->paginate($this->search_total,array('search','index',$current_action));

				$this->setResponse();

				$this->response->controller('search','index')
					->setArray(array(
						'result'	=> $this->search_result,
						'current'	=> $this->current_action,
						'query'		=> $this->search_query,
						'totla'		=> $this->search_total,
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function makeQueryFromFields($header_bar,$current_action){
			$this->table = isset($header_bar[$current_action]) ? $current_action : null;
			if($this->table && $this->search_query){
				$this->query .= "{$header_bar[$current_action]['status_field']}=" . Kernel::STATUS_ACTIVE;
				$this->query .= " AND (";
				foreach($header_bar[$current_action]['search_fields'] as $field){
					$this->order .= "length(replace({$field},%search_query%,%search_query%))+";
					$this->query .= "`{$field}` LIKE %search_query% OR ";
					$this->preparing_data['%search_query%'] = "%{$this->search_query}%";
				}
				$this->query = trim($this->query, ' OR ');
				$this->query .= ")";
				$this->order = trim($this->order,"+");
			}

			return $this;
		}

		public function setResponse(){
			$this->response->title('search.search_index_title');
			$this->response->breadcrumb('search')
				->setIcon(null)
				->setLink('search','index')
				->setValue('search.search_index_title');

			$this->response->title($this->params->header_bar[$this->current_action]['title']);
			$this->response->breadcrumb('search_action')
				->setIcon(null)
				->setLink('search','index',$this->current_action)
				->setValue($this->params->header_bar[$this->current_action]['title']);

			if($this->search_query){
				$this->response->title($this->search_query);
				$this->response->breadcrumb('search_query')
					->setIcon(null)
					->setLink('search','index',$this->current_action)
					->setValue($this->search_query);
			}

			return $this;
		}


















	}














