<?php

	namespace Core\Controllers\Audios\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Audios\Config;
	use Core\Controllers\Audios\Controller;
	use Core\Controllers\Audios\Model;

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
		public $audios;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "au_status = " . Kernel::STATUS_ACTIVE;
			$this->order = 'au_id';
			$this->sorting_panel = $this->params->sorting_panel;
		}

		public function methodGet($sorting_action='all',$sort='up'){
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$this->total = $this->model->countAudios($this->query);

			$this->setResponse();

			if($this->total){
				$this->sorting($this->sorting_panel);

				$this->audios = $this->model->getAudios(
					$this->limit,$this->offset,$this->query,$this->order,$this->sort
				);

				$this->paginate($this->total, array('audios','index'));

				$this->response->controller('audios','index')
					->setArray(array(
						'audios'	=> $this->audios
					));

				return $this;
			}
			return $this->renderEmptyPage();
		}

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelCreated(){
			$this->order = 'au_date_created';
			return null;
		}
		protected function setSortingPanelUpdated(){
			$this->order = 'au_date_updated';
			return null;
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}




















	}














