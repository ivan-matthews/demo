<?php

	namespace Core\Controllers\Audios\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Widgets\Comments;
	use Core\Controllers\Audios\Config;
	use Core\Controllers\Audios\Controller;
	use Core\Controllers\Audios\Model;

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
		public $audio_info;
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

			$this->audio_info = $this->model->getAudioByID($this->item);

			$this->setResponse();

			if($this->audio_info){

				$this->addResponse();

				$this->response->controller('audios','item')
					->setArray(array(
						'audio'	=> $this->audio_info
					));

				if($this->params->enable_comments){
					Comments::add($this->limit,$this->offset)
						->controller('audios')
						->action('item')
						->item_id($this->item)
						->paginate(array('audios','item',$this->item))
						->author($this->user_id)
						->receiver($this->audio_info['au_user_id'])
						->set();
				}
				return $this;
			}

			return false;
		}

		public function addResponse(){
			$title = fx_crop_file_name($this->audio_info['au_name'],30);

			$this->response->title($title);
			$this->response->breadcrumb('item')
				->setValue($title)
				->setIcon(null)
				->setLink('audios','item',$this->audio_info['au_id']);
			return $this;
		}




















	}














