<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;
	use Core\Controllers\Files\Model as FilesModel;

	class Files extends Controller{


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
		public $user_data;
		public $total;
		public $files;

		public $files_data;
		public $query = '';
		public $limit = 30;
		public $offset = 0;

		public $order;
		public $sort;

		public $sorting_action;
		public $sorting_type;
		public $sorting_panel;

		public $total_files;

		public $prepared_data;

		public $files_model;
		public $files_params;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "f_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND f_user_id = %user_id%";
			$this->order = 'f_id';
			$this->files_params = $this->params->loadParamsFromControllerFile('params','files');
			$this->sorting_panel = $this->files_params['sorting_panel'];
			$this->files_model = FilesModel::getInstance();
		}

		public function methodGet($user_id,$sorting_action='all',$sort='up'){
			$this->user_id = $user_id;
			$this->prepared_data['%user_id%'] = $this->user_id;
			$this->sorting_action	= $sorting_action;
			$this->sorting_type		= $sort;
			$this->sort = isset($this->sorting_types[$this->sorting_type]) ? $this->sorting_types[$this->sorting_type] : 'DESC';

			$this->user_data = $this->model->getUserByID($this->user_id);

			if($this->user_data){

				$this->addResponse();

				$this->total_files = $this->files_model->countFiles($this->query,$this->prepared_data);

				$this->prepareSortingPanel()->sorting($this->sorting_panel);

				$this->files_data = $this->files_model->getFiles(
					$this->limit,$this->offset,$this->query,$this->order,$this->sort,$this->prepared_data
				);

				$this->paginate($this->total_files, array('users','files',$this->user_id));

				$this->response->controller('users','files')
					->setArray(array(
						'files'	=> $this->files_data
					));

				return $this;
			}

			return false;
		}

		public function prepareSortingPanel(){
			foreach($this->sorting_panel as $key=>$value){
				$post_array = array_slice($this->sorting_panel[$key]['link'],2);
				$new_array = array('users','files',$this->user_id);
				array_push($new_array,...$post_array);
				$this->sorting_panel[$key]['link'] = $new_array;
			}
			return $this;
		}

		protected function setSortingPanelAll(){
			return null;
		}
		protected function setSortingPanelCreated(){
			$this->order = 'f_date_created';
			return null;
		}
		protected function setSortingPanelUpdated(){
			$this->order = 'f_date_updated';
			return null;
		}
		protected function setSortingPanelRandom(){
			$this->order = 'RAND()';
			return null;
		}

		public function addResponse(){
			$this->response->title($this->user_data['u_full_name']);
			$this->response->breadcrumb('user')
				->setIcon(null)
				->setLink('users','item',$this->user_data['u_id'])
				->setValue($this->user_data['u_full_name']);
			return $this->appendResponse();
		}

		public function appendResponse(){
			$this->response->title('files.files_index_title');
			$this->response->breadcrumb('index')
				->setIcon(null)
				->setLink('users','files',$this->user_data['u_id'])
				->setValue('files.files_index_title');
			return $this;
		}
















	}














