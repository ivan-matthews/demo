<?php

	namespace Core\Controllers\Photos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Photos\Config;
	use Core\Controllers\Photos\Controller;
	use Core\Controllers\Photos\Model;

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

		/** @var integer */
		public $item;
		public $photo;
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
			$this->query .= "photos.p_status =" . Kernel::STATUS_ACTIVE;
		}

		public function methodGet($item_id){
			$this->item = $item_id;

			$this->photo = $this->model->getPhotoById($this->item,$this->query);

			$this->setResponse();

			if($this->photo){
				$this->addResponse();

				$this->response->controller('photos','item')
					->setArray(array(
						'photo'	=> $this->photo
					));

				Comments::add($this->limit,$this->offset)
//					->setProp('wa_position','photo_info')
//					->setProp('wa_template','controllers/photos/widgets/comments')
//					->setProp('w_template','controllers/photos/widgets/comments')
					->controller('photos')
					->action('item')
					->item_id($this->item)
					->paginate(array('photos','item',$this->item))
					->author($this->user_id)
					->receiver($this->photo['p_user_id'])
					->set();

				return $this;
			}

			return false;
		}

		public function addResponse(){
			$this->response->title($this->photo['p_name']);
			$this->response->breadcrumb('item')
				->setValue($this->photo['p_name'])
				->setLink('photos','item',$this->item)
				->setIcon(null);
			return $this;
		}




















	}














