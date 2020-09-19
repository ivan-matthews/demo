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

	class Photo extends Controller{

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
		public $photo;

		public $limit = 30;
		public $offset = 0;
		public $total;
		public $order = 'p_id';
		public $sort = 'DESC';

		public $user_id;
		public $photo_model;
		public $photo_content;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->backLink();
			$this->photo_model = PhotosModel::getInstance();
			$this->user_id = $this->user->getUID();
			$this->query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND p_user_id = {$this->user_id}";

			$this->backLink();
		}

		public function methodGet(){
			$this->total = $this->photo_model->countPhotos($this->query);
			$this->photo_content = $this->photo_model->getPhotos(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort
			);

			$this->response->controller('attachments','photo')
				->setArray(array(
					'total'		=> $this->total,
					'limit'		=> $this->limit,
					'offset'	=> $this->offset,
					'link'		=> fx_get_url('attachments','photo'),	// позже добавим параметры сортировки
					'images'	=> $this->photo_content
				));
			return $this;
		}


















	}














