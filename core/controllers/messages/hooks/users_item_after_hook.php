<?php

	namespace Core\Controllers\Messages\Hooks;

	use Core\Classes\Session;
	use Core\Controllers\Users\Actions\Item as UserAccountPage;

	class Users_Item_After_Hook{

		public $user_object;

		public function __construct(){
			$this->user_object = UserAccountPage::getInstance();
		}

		public function run(){
			if($this->user_object->user->logged()){
				if(fx_equal($this->user_object->user_id,$this->user_object->session->get('u_id',Session::PREFIX_AUTH))){
					return $this;
				}
				$this->user_object->user_menu['add_contact']	= array(
					'link'			=> fx_get_url('messages','add',$this->user_object->user_id),
					'value'			=> fx_lang('messages.add_user_to_contacts_list'),
					'icon'			=> 'far fa-envelope',
					'link_class'	=> '',
					'icon_class'	=> '',
				);
				$this->setResponse();
			}
			return $this;
		}

		public function setResponse(){
			$this->user_object->response->controller('users','item')
				->set('menu', $this->user_object->user_menu);
			return $this;
		}
	}