<?php

	namespace Core\Controllers\Files\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Files\Config;
	use Core\Controllers\Files\Controller;
	use Core\Controllers\Files\Model;

	class Item extends Controller{

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

		/** @var string */
		public $item;

		public $limit = 30;
		public $offset = 0;
		public $file_info;
		public $user_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($item_id){
			$this->item = $item_id;

			$this->file_info = $this->model->getFileByID($this->item);

			$this->setResponse();

			if($this->file_info){

				$this->addResponse();

				$this->response->controller('files','item')
					->setArray(array(
						'file'	=> $this->file_info
					));

				if($this->params->enable_comments){
					Comments::add($this->limit,$this->offset)
						->controller('files')
						->action('item')
						->item_id($this->item)
						->paginate(array('files','item',$this->item))
						->author($this->user_id)
						->receiver($this->file_info['f_user_id'])
						->set();
				}
				return $this;
			}

			return false;
		}

		public function addResponse(){
			$user = fx_get_full_name($this->file_info['u_full_name'],$this->file_info['u_gender']);
			$this->response->title($user);
			$this->response->breadcrumb('user')
				->setValue($user)
				->setLink('users','item',$this->file_info['u_id'])
				->setIcon(null);
			return $this->appendResponse();
		}

		public function appendResponse(){
			$title = fx_crop_file_name($this->file_info['f_name'],30);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setValue($title)
				->setIcon(null)
				->setLink('files','item',$this->file_info['f_id']);
			return $this;
		}




















	}














