<?php

	namespace Core\Controllers\Photos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Photos\Config;
	use Core\Controllers\Photos\Controller;
	use Core\Controllers\Photos\Model;

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

		public $photos_data;
		public $query = '';
		public $limit = 30;
		public $offset = 0;

		public $order;
		public $sort;

		public $sorting_action;
		public $sorting_type;
		public $sorting_panel = array();

		public $total_photos;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$this->order = 'p_id';
			$this->sorting_panel = $this->params->sorting_panel;
		}

		public function methodGet($sorting_action='all',$sort='up'){
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$this->total_photos = $this->model->countPhotos($this->query);

			$this->setResponse();

			if($this->total_photos){

				$this->sorting($this->sorting_panel);

				$this->photos_data = $this->model->getPhotos(
					$this->limit,$this->offset,$this->query,$this->order,$this->sort
				);

				$this->paginate($this->total_photos, array('photos','index'));

				$this->response->controller('photos','index')
					->setArray(array(
						'photos'	=> $this->photos_data
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelCreated(){
			$this->order = 'p_date_created';
			return null;
		}
		protected function setSortingPanelUpdated(){
			$this->order = 'p_date_updated';
			return null;
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}



















	}














