<?php

	namespace Core\Controllers\Attachments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Attachments\Config;
	use Core\Controllers\Attachments\Controller;
	use Core\Controllers\Attachments\Model;
	use Core\Controllers\Videos\Model as VideosModel;

	class Videos extends Controller{

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
		public $videos;

		public $limit = 30;
		public $offset = 0;
		public $total;
		public $order = 'v_id';
		public $sort = 'DESC';

		public $user_id;
		public $videos_model;
		public $videos_content;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->videos_model = VideosModel::getInstance();
			$this->user_id = $this->user->getUID();
			$this->query .= "v_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND v_user_id = {$this->user_id}";
		}

		public function methodGet($ids_list=false){
			$this->total = $this->videos_model->countVideos($this->query);
			$this->videos_content = $this->videos_model->getVideos(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort
			);

			$this->response->controller('attachments','videos')
				->setArray(array(
					'total'		=> $this->total,
					'content'	=> $this->videos_content,
					'ids_list'	=> explode(',',$ids_list)
				));
			return $this;
		}


















	}














