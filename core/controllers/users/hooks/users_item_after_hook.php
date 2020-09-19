<?php

	namespace Core\Controllers\Users\Hooks;

	use Core\Controllers\Users\Actions\Item as UserAccountPage;

	/**
	 * Пример перезаписи ответа:<br>
	 * переустановка ключа `menu` в массиве `response -> controller -> users -> item`
	 *
	 * Class Users_Item_After_Hook
	 * @package Core\Controllers\Users\Hooks
	 */
	class Users_Item_After_Hook{

		public $user_object;

		public function __construct(/*UserAccountPage $user_account_page*/){
			$this->user_object = UserAccountPage::getInstance();
		}

		public function run(){
			if($this->user_object->user_data && fx_me($this->user_object->user_id)){
				$this->user_object->user_menu['edit_profile']	= array(
					'link'			=> fx_get_url('users','edit',$this->user_object->user_id),
					'value'			=> fx_lang('users.edit_profile_link_value'),
					'icon'			=> 'fas fa-pen',
					'link_class'	=> 'btn-light',
					'icon_class'	=> '',
				);
				return $this->setResponse();
			}
			return $this;
		}

		public function setResponse(){
			$this->user_object->response->controller('users','item')
				->set('menu', $this->user_object->user_menu);
			return $this;
		}
	}