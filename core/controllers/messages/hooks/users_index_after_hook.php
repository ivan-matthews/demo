<?php

	namespace Core\Controllers\Messages\Hooks;

	use Core\Classes\Session;
	use Core\Controllers\Users\Actions\Index as UsersList;

	class Users_Index_After_Hook{

		public $users_object;

		public function __construct(){
			$this->users_object = UsersList::getInstance();
		}

		public function run(){
			if($this->users_object->all_users_data){
				foreach($this->users_object->all_users_data as $key=>$val){
					if(fx_equal($val['u_id'], $this->users_object->session->get('u_id',Session::PREFIX_AUTH))){
						continue;
					}
					$this->users_object->all_users_data[$key]['menu']['add_contact']	= array(
						'link'			=> fx_get_url('messages','add',$val['u_id']),
						'value'			=> fx_lang('messages.add_user_to_contacts_list'),
						'icon'			=> 'far fa-envelope',
						'link_class'	=> 'add-message',
						'icon_class'	=> '',
					);
				}
			}
			return $this->setResponse();
		}

		public function setResponse(){
			$this->users_object->response->controller('users','index')
				->set('users',$this->users_object->all_users_data);
			return $this;
		}
	}