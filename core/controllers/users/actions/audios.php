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
	use Core\Controllers\Audios\Model as AudiosModel;

	class Audios extends Controller{


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
		public $audios;

		public $audios_data;
		public $query = '';
		public $limit = 30;
		public $offset = 0;

		public $order;
		public $sort;

		public $sorting_action;
		public $sorting_type;
		public $sorting_panel;

		public $total_audios;

		public $prepared_data;

		public $audios_model;
		public $audios_params;

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
			$this->query .= " AND au_user_id = %user_id%";
			$this->order = 'au_id';
			$this->audios_params = $this->params->loadParamsFromControllerFile('params','audios');
			$this->sorting_panel = $this->audios_params['sorting_panel'];
			$this->audios_model = AudiosModel::getInstance();
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

				$this->total_audios = $this->audios_model->countAudios($this->query,$this->prepared_data);

				if($this->total_audios){
					$this->prepareSortingPanel()->sorting($this->sorting_panel);

					$this->audios_data = $this->audios_model->getAudios(
						$this->limit,$this->offset,$this->query,$this->order,$this->sort,$this->prepared_data
					);

					$this->paginate($this->total_audios, array('users','audios',$this->user_id));

					$this->response->controller('users','audios')
						->setArray(array(
							'audios'	=> $this->audios_data
						));

					return $this;
				}
				return $this->renderEmptyPage();
			}

			return false;
		}

		public function prepareSortingPanel(){
			foreach($this->sorting_panel as $key=>$value){
				$post_array = array_slice($this->sorting_panel[$key]['link'],2);
				$new_array = array('users','audios',$this->user_id);
				array_push($new_array,...$post_array);
				$this->sorting_panel[$key]['link'] = $new_array;
			}
			return $this;
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

		public function addResponse(){
			$this->response->title($this->user_data['u_full_name']);
			$this->response->breadcrumb('user')
				->setIcon(null)
				->setLink('users','item',$this->user_data['u_id'])
				->setValue($this->user_data['u_full_name']);
			return $this->appendResponse();
		}

		public function appendResponse(){
			$this->response->title('audios.audios_index_title');
			$this->response->breadcrumb('index')
				->setIcon(null)
				->setLink('users','audios',$this->user_data['u_id'])
				->setValue('audios.audios_index_title');
			return $this;
		}
















	}














