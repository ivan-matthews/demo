<?php

	namespace Core\Widgets;

	use Core\Classes\Response\Response;
	use Core\Classes\Session;
	use Core\Controllers\Users\Model as UserModel;
	use Core\Controllers\Home\Model as HomeModel;

	class User_info{

		private $params;
		private $user_info;
		private $user_id;
		private $user_menu;

		private $session;
		private $response;
		private $user_model;
		private $home_model;

		public function __construct($params_list){
			$this->params = $params_list;
			$this->response = Response::getInstance();
			$this->session = Session::getInstance();
			$this->user_model = UserModel::getInstance();
			$this->home_model = HomeModel::getInstance();
		}

		public function run(){
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
			$this->user_menu = $this->home_model->getMenuLinksByWidgetId($this->params['wa_id']);
			$this->prepareLinks();
			$this->user_info = array(
				'id'		=> $this->user_id,
				'avatar'	=> $this->session->get('p_micro',Session::PREFIX_AUTH),
				'gender'	=> $this->session->get('u_gender',Session::PREFIX_AUTH),
				'name'		=> $this->session->get('u_full_name',Session::PREFIX_AUTH),
				'notice'	=> $this->user_model->countUserNoticesById($this->user_id),
				'mail'		=> 0,
//				'mail'		=> $this->user_model->countUserMessagesById($this->user_id)
				'menu'		=> $this->user_menu
			);
			return $this->user_info;
		}

		private function prepareLinks(){
			foreach($this->user_menu as $key=>$value){
				$this->user_menu[$key]['l_link_array'] = fx_url(fx_arr($value['l_link_array']));
			}
			return $this;
		}

	}