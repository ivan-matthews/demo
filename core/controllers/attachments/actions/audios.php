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
		public $audios;

		public $limit = 30;
		public $offset = 0;
		public $total;
		public $order = 'au_id';
		public $sort = 'DESC';

		public $user_id;
		public $audios_model;
		public $audios_content;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->audios_model = AudiosModel::getInstance();
			$this->user_id = $this->user->getUID();
			$this->query .= "au_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND au_user_id = {$this->user_id}";
		}

		public function methodGet($ids_list=false){
			$this->total = $this->audios_model->countAudios($this->query);
			$this->audios_content = $this->audios_model->getAudios(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort
			);

			$this->response->controller('attachments','audios')
				->setArray(array(
					'total'		=> $this->total,
					'limit'		=> $this->limit,
					'offset'	=> $this->offset,
					'link'		=> fx_get_url('attachments','audios', $ids_list),	// позже добавим параметры сортировки
					'content'	=> $this->audios_content,
					'ids_list'	=> explode(',',$ids_list)
				));
			return $this;
		}


















	}














