<?php

	namespace Core\Controllers\Avatar\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Avatar\Config;
	use Core\Controllers\Avatar\Controller;
	use Core\Controllers\Avatar\Model;
	use Core\Controllers\Users\Model as UserModel;

	class Set extends Controller{

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
		public $set;

		public $user_id;
		public $avatar_id;
		public $user_model;

		public $avatar_data;
		public $update_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->user_model = UserModel::getInstance();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($avatar_id){
			$this->avatar_id = $avatar_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->avatar_data = $this->model->getAvatarByID($this->avatar_id,$this->user_id);

			if($this->avatar_data){

				$this->user_model->updateAvatarId($this->user_id,$this->avatar_id);

				$this->update_data = $this->avatar_data;
				$this->update_data['u_avatar_id'] = $this->update_data['p_id'];

				$this->sessionUpdate($this->update_data);

				return $this->redirect();
			}

			return false;
		}

















	}














