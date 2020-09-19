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

	class User extends Controller{

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
		public $_this;

		public $user_id;
		public $total;
		public $photos;

		public $photos_data;
		public $query = '';
		public $limit = 30;
		public $offset = 0;

		public $order;
		public $sort;

		public $sorting_action;
		public $sorting_type;
		public $sorting_panel;

		public $total_photos;

		public $prepared_data;

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
			$this->query .= " AND p_user_id = %user_id%";
			$this->order = 'p_id';
			$this->sorting_panel = $this->params->sorting_panel;
		}

		public function methodGet($user_id,$sorting_action='all',$sort='up'){
			$this->user_id = $user_id;
			$this->prepared_data['%user_id%'] = $this->user_id;
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$this->total_photos = $this->model->countPhotos($this->query,$this->prepared_data);

			$this->setResponse();

			if($this->total_photos){

				$this->prepareSortingPanel()->sorting($this->sorting_panel);

				$this->photos_data = $this->model->getPhotos(
					$this->limit,$this->offset,$this->query,$this->order,$this->sort,$this->prepared_data
				);

				$this->paginate($this->total_photos, array('photos','user',$this->user_id));

				$this->response->controller('photos','index')
					->setArray(array(
						'photos'	=> $this->photos_data
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function prepareSortingPanel(){
			foreach($this->sorting_panel as $key=>$value){
				$post_array = array_slice($this->sorting_panel[$key]['link'],2);
				$new_array = array('photos','user',$this->user_id);
				array_push($new_array,...$post_array);
				$this->sorting_panel[$key]['link'] = $new_array;
			}
			return $this;
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














