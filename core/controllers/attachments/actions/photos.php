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
	use Core\Controllers\Photos\Model as PhotosModel;

	class Photos extends Controller{

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
		public $photos;

		public $limit = 30;
		public $offset = 0;
		public $total;
		public $order = 'p_id';
		public $sort = 'DESC';

		public $user_id;
		public $photos_model;
		public $photos_content;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->photos_model = PhotosModel::getInstance();
			$this->user_id = $this->user->getUID();
			$this->query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND p_user_id = {$this->user_id}";
		}

		public function methodGet($ids_list=false){
			$this->total = $this->photos_model->countPhotos($this->query);
			$this->photos_content = $this->photos_model->getPhotos(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort
			);

			$this->response->controller('attachments','photos')
				->setArray(array(
					'total'		=> $this->total,
					'content'	=> $this->photos_content,
					'ids_list'	=> explode(',',$ids_list)
				));
			return $this;
		}


















	}














