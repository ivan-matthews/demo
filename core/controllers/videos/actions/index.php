<?php

	namespace Core\Controllers\Videos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Videos\Config;
	use Core\Controllers\Videos\Controller;
	use Core\Controllers\Videos\Model;

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

		public $sorting_panel = array();
		public $videos;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "v_status = " . Kernel::STATUS_ACTIVE;
			$this->order = 'v_id';
			$this->sorting_panel = $this->params->sorting_panel;
		}

		public function methodGet($sorting_action='all',$sort='up'){
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$this->total = $this->model->countVideos($this->query);

			$this->setResponse();

			if($this->total){
				$this->sorting($this->sorting_panel);

				$this->videos = $this->model->getVideos(
					$this->limit,$this->offset,$this->query,$this->order,$this->sort
				);

				$this->paginate($this->total, array('videos','index'));

				$this->response->controller('videos','index')
					->setArray(array(
						'videos'	=> $this->videos
					));

				return $this;
			}
			return $this->renderEmptyPage();
		}

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelCreated(){
			$this->order = 'v_date_created';
			return null;
		}
		protected function setSortingPanelUpdated(){
			$this->order = 'v_date_updated';
			return null;
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}




















	}














