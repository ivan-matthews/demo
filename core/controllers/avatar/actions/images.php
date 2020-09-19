<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;

	class Images extends Controller{

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
		public $images;
		public $user_id;

		public $limit=30;
		public $offset=0;

		public $avatars = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->query .= "`p_status` = " . Kernel::STATUS_ACTIVE;
			$this->user_id = $this->user->getUID();
		}

		public function methodGet(){
			$this->avatars = $this->model->getAllUserAvatars($this->user_id,$this->limit,$this->offset,$this->query,'p_id','DESC');

			$this->response->controller('avatar','images')
				->setArray(array(
					'images'	=> $this->avatars
				));

			return $this;
		}




















	}














