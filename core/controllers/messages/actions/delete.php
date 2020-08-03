<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Model;

	class Delete extends Controller{

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
		public $delete;

		public $user_id;
		public $message_id;

		public $message_info = array();

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
			$this->backLink();
		}

		public function methodGet($message_id){
			$this->message_id = $message_id;

			$this->message_info = $this->model->getMessageById($this->message_id);

			if($this->message_info){

				if(fx_equal($this->user_id,$this->message_info['mc_sender_id'])
					&& fx_equal($this->user_id,$this->message_info['mc_user_id'])){
					$this->model->hideOwnMessage($this->message_id);
				}else{
					if(fx_equal($this->user_id,$this->message_info['mc_sender_id'])){

						$this->model->hideSenderMessage($this->message_id);
					}else
						if(fx_equal($this->user_id,$this->message_info['mc_user_id'])){
							$this->model->hideMyMessage($this->message_id);
						}
				}
				return $this->redirect();
			}

			return false;
		}





















	}














