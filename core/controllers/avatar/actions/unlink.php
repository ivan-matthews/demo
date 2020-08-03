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
	use Core\Classes\View;

	class Unlink extends Controller{

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

		public $view;

		/** @var array */
		public $unlink;

		public $user_id,
			$avatar_id;

		public $avatar_data;

		public $user_model;

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

			$this->view = View::getInstance();
			$this->user_model = UserModel::getInstance();
		}

		public function methodGet($user_id,$avatar_id){
			$this->user_id = $user_id;
			$this->avatar_id = $avatar_id;

			if(!fx_me($this->user_id)){ return false; }

			$this->avatar_data = $this->model->getAvatarByID($this->avatar_id,$this->user_id);

			if($this->avatar_data){

				unlink($this->view->getUploadDir($this->avatar_data["p_original"]));

				foreach($this->params->image_params as $key=>$value){
					unlink($this->view->getUploadDir($this->avatar_data["p_{$key}"]));
				}

				$this->model->dropAvatarItem($this->avatar_id,$this->user_id);

				$this->user_model->updateAvatarId($this->user_id,null);

				return $this->redirect(fx_get_url('users','item',$this->user_id));
			}

			return false;
		}




















	}














