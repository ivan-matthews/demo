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

		public $user_model;

		public $user_id;
		public $avatar_id;
		public $delete_data = array();

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
		}

		public function methodGet($user_id,$avatar_id){
			$this->user_id = $user_id;
			$this->avatar_id = $avatar_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->delete_data = array(
				'p_user_id'			=> $this->user_id,
				'p_date_deleted'	=> time(),
			);

			if($this->model->deleteAvatar($this->delete_data,$this->avatar_id)){

				$this->user_model->updateAvatarId($this->user_id,null);

				return $this->updateSession()
					->redirect();
			}

			return false;
		}

		public function updateSession(){
			$this->session->set('p_user_id',null,Session::PREFIX_AUTH);
			$this->session->set('p_name',null,Session::PREFIX_AUTH);
			$this->session->set('p_size',null,Session::PREFIX_AUTH);
			$this->session->set('p_hash',null,Session::PREFIX_AUTH);
			$this->session->set('p_mime',null,Session::PREFIX_AUTH);
			$this->session->set('p_status',null,Session::PREFIX_AUTH);
			$this->session->set('p_date_created',null,Session::PREFIX_AUTH);
			$this->session->set('p_original',null,Session::PREFIX_AUTH);
			$this->session->set('p_micro',null,Session::PREFIX_AUTH);
			$this->session->set('p_small',null,Session::PREFIX_AUTH);
			$this->session->set('p_medium',null,Session::PREFIX_AUTH);
			$this->session->set('p_normal',null,Session::PREFIX_AUTH);
			$this->session->set('p_big',null,Session::PREFIX_AUTH);

			return $this;
		}
















	}














