<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;
	use Core\Controllers\Users\Forms\Edit as EditForm;

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

		public $form_name = 'edit';

		public $edit_form;
		public $user_id;
		public $user_data;
		public $fields_list;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->edit_form = EditForm::getInstance($this->form_name);
			$this->fields_list = $this->params->loadParamsFromControllerFile('fields');
		}

		public function methodGet($user_id,$header_bar_action='field_set_name'){
			$this->user_id = $user_id;

			if(!fx_me($this->user_id)){ return false; }

			$this->fields_list = $this->prepareFieldsByHeaderBar($header_bar_action);

			$this->user_data = $this->model->getUserByID($this->user_id);

			if($this->user_data){

				$this->setResponseInfo();

				$this->edit_form->setFields($this->fields_list,$this->user_data);

				if(fx_equal($header_bar_action,'geo_info')){
					$this->edit_form->geo('u_country_id','u_region_id','u_city_id');
				}

				$this->header_bar($this->params->header_bar_user_edit,array('users','edit',$this->user_id),$header_bar_action);

				return $this->response->controller('users','edit')
					->set('fields',$this->edit_form->getFieldsList())
					->set('form',$this->edit_form->getFormAttributes())
					->set('errors',$this->edit_form->getErrors())
					->set('user',$this->user_data);
			}

			return false;
		}

		public function methodPost($user_id,$header_bar_action='field_set_name'){
			$this->user_id = $user_id;

			if(!fx_me($this->user_id)){ return false; }

			$this->fields_list = $this->prepareFieldsByHeaderBar($header_bar_action);

			$this->user_data = $this->model->getUserByID($this->user_id);

			if($this->user_data){

				$this->setResponseInfo();

				$this->edit_form->checkForm($this->fields_list,$this->request->getArray($this->form_name));

				if(fx_equal($header_bar_action,'geo_info')){
					$this->edit_form->geo('u_country_id','u_region_id','u_city_id');
				}

				$this->header_bar($this->params->header_bar_user_edit,array('users','edit',$this->user_id),$header_bar_action);

				$fields_list = $this->edit_form->getFieldsList();

				if($this->edit_form->can()){
					$this->model->updateUserInfoByUserId($this->prepareFields($fields_list),$this->fields_list,$this->user_id);
					$this->sessionUpdate($this->prepareFields($fields_list),$this->fields_list);
				}

				return $this->response->controller('users','edit')
					->set('fields',$fields_list)
					->set('form',$this->edit_form->getFormAttributes())
					->set('errors',$this->edit_form->getErrors())
					->set('user',$this->user_data);
			}

			return false;
		}

		private function sessionUpdate(array $fields_list, array $compare_fields){
			foreach($compare_fields as $compare_field){
				if(!isset($fields_list[$compare_field['field']])){ continue; }
				$this->session->update($compare_field['field'],$fields_list[$compare_field['field']]['attributes']['value'],Session::PREFIX_AUTH);
			}
			return $this;
		}

		private function prepareFields(array $fields_list){
			if(isset($fields_list['u_full_name'])){
				$fields_list['u_full_name'] = $fields_list['u_first_name'];
				$fields_list['u_full_name']['attributes']['value'] .= ' ' . $fields_list['u_last_name']['attributes']['value'];
			}
			return $this->prepareGeo($fields_list);
		}

		private function prepareGeo($fields_list){
			if(isset($fields_list['geo'])){
				$this->fields_list[] = array('field'	=> 'u_country_id');
				$this->fields_list[] = array('field'	=> 'u_region_id');
				$this->fields_list[] = array('field'	=> 'u_city_id');

				$fields_list['u_country_id'] = $fields_list['u_region_id'] = $fields_list['u_city_id'] = $fields_list['geo'];
				$fields_list['u_country_id']['attributes']['value'] = $fields_list['geo']['attributes']['params']['country']['id'];
				$fields_list['u_region_id']['attributes']['value'] = $fields_list['geo']['attributes']['params']['region']['id'];
				$fields_list['u_city_id']['attributes']['value'] = $fields_list['geo']['attributes']['params']['city']['id'];
			}
			return $fields_list;
		}

		private function prepareFieldsByHeaderBar($field_set){
			$fields_list = array();
			foreach($this->fields_list as $field){
				if(!fx_equal($field_set,$field['params']['field_sets'])){ continue; }
				$fields_list[] = $field;
			}
			return $fields_list;
		}

		private function setResponseInfo(){
			$this->response->title('users.edit_page_title');
			$this->response->title($this->user_data['u_full_name']);

			$this->response->breadcrumb('user_page')
				->setIcon(null)
				->setValue($this->user_data['u_full_name'])
				->setLink('users','item',$this->user_id);

			$this->response->breadcrumb('edit_page')
				->setIcon(null)
				->setValue('users.edit_page_title')
				->setLink('users','edit',$this->user_id);

			return $this;
		}
















	}














