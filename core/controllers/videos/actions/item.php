<?php

	namespace Core\Controllers\Videos\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Videos\Config;
	use Core\Controllers\Videos\Controller;
	use Core\Controllers\Videos\Model;

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
		public $video_info;
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
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($item_id){
			$this->item = $item_id;

			$this->video_info = $this->model->getVideoByID($this->item);

			$this->setResponse();

			if($this->video_info){

				$this->addResponse();

				$this->response->controller('videos','item')
					->setArray(array(
						'video'	=> $this->video_info
					));

				if($this->params->enable_comments){
					Comments::add($this->limit,$this->offset)
						->controller('videos')
						->action('item')
						->item_id($this->item)
						->paginate(array('videos','item',$this->item))
						->author($this->user_id)
						->receiver($this->video_info['v_user_id'])
						->set();
				}
				return $this;
			}

			return false;
		}

		public function addResponse(){
			$video_info = pathinfo($this->video_info['v_name']);
			$title = fx_crop_string($video_info['filename'],30);
			$title = "{$title}.{$video_info['extension']}";

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setValue($title)
				->setIcon(null)
				->setLink('videos','item',$this->video_info['v_id']);
			return $this;
		}




















	}













