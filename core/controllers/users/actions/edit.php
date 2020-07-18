<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;
	use Core\Classes\Form\Form;

	class Edit extends Controller{

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
		public $edit;

		public $limit;
		public $offset;
		public $total;
		public $order;
		public $sort;

		public $user_id;
		public $user_data;
		public $fields;

		public $fields_list;
		public $header_bar = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->form = new Form();
			$this->response->title('users.edit_page_title');
		}

		public function methodGet($user_id,$edit_action='name'){
			$this->user_id = $user_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->user_data = $this->model->getUserByID($this->user_id);

			if($this->user_data){

				$this->response->title($this->user_data['u_full_name']);

				$this->response->breadcrumb('user_page')
					->setIcon(null)
					->setValue($this->user_data['u_full_name'])
					->setLink('users','item',$this->user_id);

				$this->response->breadcrumb('edit_page')
					->setIcon(null)
					->setValue('users.edit_page_title')
					->setLink('users','edit',$this->user_id);

				$this->fields = $this->params->getParams('fields');
				$this->form->setData($this->user_data);
				$this->form->geo('u_country_id','u_region_id','u_city_id');
				$this->form->setArrayFields($this->fields);
				$this->form->checkArrayFields();

				$this->fields_list = $this->form->getFieldsList();

				$this->header_bar = $this->params->header_bar_user_edit;
				$this->updateHeaderBarLinks();
				$this->header_bar($this->header_bar,$edit_action);

				return $this->response->controller('users','edit')
					->set('fields',$this->fields_list)
					->set('form',$this->form->getFormAttributes())
					->set('errors',$this->form->getErrors())
					->set('user',$this->user_data);
			}
			return false;
		}

		public function methodPost($user_id,$edit_action='name'){
			$this->user_id = $user_id;
			if(!fx_me($this->user_id)){ return false; }

			$this->user_data = $this->model->getUserByID($this->user_id);

			if($this->user_data){
				$this->response->title($this->user_data['u_full_name']);

				$this->response->breadcrumb('user_page')
					->setIcon(null)
					->setValue($this->user_data['u_full_name'])
					->setLink('users','item',$this->user_id);

				$this->response->breadcrumb('edit_page')
					->setIcon(null)
					->setValue('users.edit_page_title')
					->setLink('users','edit',$this->user_id);

				$this->fields = $this->params->getParams('fields');

				$this->form->csrf(1);
				$this->form->validate(1);

				$this->form->setData($this->request->getAll());
				$this->form->geo('u_country_id','u_region_id','u_city_id');
				$this->form->setArrayFields($this->fields);
				$this->form->checkArrayFields();

				$this->fields_list = $this->form->getFieldsList();

				$this->header_bar = $this->params->header_bar_user_edit;
				$this->updateHeaderBarLinks();
				$this->header_bar($this->header_bar,$edit_action);

				if($this->form->can()){
					$fields = $this->fields_list;

					if(isset($fields['u_first_name'])){
						$fields['u_full_name'] = $fields['u_first_name'];
						$fields['u_full_name']['attributes']['value'] = $fields['u_first_name']['attributes']['value'];
						$fields['u_full_name']['attributes']['value'] .= ' ';
						$fields['u_full_name']['attributes']['value'] .= $fields['u_last_name']['attributes']['value'];
					}

					if(isset($fields['geo'])){
						$fields['u_country_id']['attributes']['value']	= $fields['geo']['attributes']['params']['country']['id'];
						$fields['u_region_id']['attributes']['value']	= $fields['geo']['attributes']['params']['region']['id'];
						$fields['u_city_id']['attributes']['value']	= $fields['geo']['attributes']['params']['city']['id'];
						unset($fields['geo']);
					}

					if($this->model->updateUserData($fields,$this->user_id)){
						foreach($fields as $key=>$value){
							$this->session->update($key,$value['attributes']['value'],Session::PREFIX_AUTH);
						}
					}
				}

				return $this->response->controller('users','edit')
					->set('fields',$this->fields_list)
					->set('form',$this->form->getFormAttributes())
					->set('errors',$this->form->getErrors())
					->set('user',$this->user_data);
			}
			return false;
		}

		protected function nameHeaderBar(){
			$this->fields_list = $this->prepareFields('field_set_name');
			return $this;
		}
		protected function geoHeaderBar(){
			$this->fields_list = $this->prepareFields('geo_info');
			return $this;
		}
		protected function oldHeaderBar(){
			$this->fields_list = $this->prepareFields('field_set_birth_date');
			return $this;
		}
		protected function contactsHeaderBar(){
			$this->fields_list = $this->prepareFields('field_set_contacts');
			return $this;
		}
		protected function aboutHeaderBar(){
			$this->fields_list = $this->prepareFields('field_set_activities');
			return $this;
		}

		private function prepareFields($field_set){
			$fields = array();
			foreach($this->fields_list as $key=>$value){
				if(fx_equal($key,'csrf')){
					$fields[$key] = $value;
					continue;
				}
				if(!fx_equal($field_set,$value['attributes']['params']['field_sets'])){
					continue;
				}
				$fields[$key] = $value;
			}
			return $fields;
		}

		private function updateHeaderBarLinks(){

			$this->header_bar['name']['link'] = array('users','edit',$this->user_id);
			$this->header_bar['geo']['link'] = array('users','edit',$this->user_id,'geo');
			$this->header_bar['old']['link'] = array('users','edit',$this->user_id,'old');
			$this->header_bar['contacts']['link'] = array('users','edit',$this->user_id,'contacts');
			$this->header_bar['about']['link'] = array('users','edit',$this->user_id,'about');

			return $this;
		}
















	}














