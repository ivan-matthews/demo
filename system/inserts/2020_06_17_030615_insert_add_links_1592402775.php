<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;

	class InsertAddLinks202006170306151592402775{

		protected $links_array = array(
			array(
				'menu_id'		=> 3,
				'link_array'	=> null,
				'name'			=> 'home_page',
				'title'			=> 'home.home_link_title',
				'value'			=> 'home.home_link',
			),
			array(
				'menu_id'		=> 1,
				'link_array'	=> array(
					'auth','index'
				),
				'name'			=> 'auth_page',
				'title'			=> 'auth.auth_link_title',
				'value'			=> 'auth.auth_link',
			),
			array(
				'menu_id'		=> 1,
				'link_array'	=> array(
					'auth','registration'
				),
				'name'			=> 'auth_sign_up',
				'title'			=> 'auth.registration_link_title',
				'value'			=> 'auth.registration_link',
			),
			array(
				'menu_id'		=> 2,
				'link_array'	=> array(
					'auth','logout'
				),
				'name'			=> 'auth_log_out',
				'title'			=> 'auth.logout_link_title',
				'value'			=> 'auth.logout_link',
			)
		);

		public function firstStep(){
			$insert_request = Database::insert('links');
			foreach($this->links_array as $link){
				$insert_request->value('menu_id',$link['menu_id']);
				$insert_request->value('link_array',$link['link_array']);
				$insert_request->value('name',$link['name']);
				$insert_request->value('title',$link['title']);
				$insert_request = $insert_request->value('value',$link['value']);
			}
			$insert_request->get()->id();
		}











	}