<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertUserMenuSidebar202008040856031596570963{

		private $ordering;
		private $active_widget_id;
		private $menu_id;

		public function updateSidebarOrderingPositions(){
			$this->ordering = Database::update('widgets_active')
				->query('wa_ordering','wa_ordering+1')
				->where("wa_position='sidebar'")
				->get()
				->rows();
			return $this;
		}

		public function addActiveWidget(){
			Database::insert('widgets_active')
				->value('wa_name','user_info_sidebar')
				->query('wa_widget_id',15)
				->value('wa_title','home.user_info_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','sidebar')
				->value('wa_ordering',1)
				->value('wa_template','controllers/users/widgets/user_info')
				->value('wa_groups_disabled',array(0))
				->update('wa_position','sidebar')
				->get()
				->id();
			return $this;
		}

		public function addUserMenu(){
			$this->menu_id = Database::insert('menu')
				->value('m_widget_id',$this->active_widget_id)
				->value('m_name','user_info_sidebar_menu')
				->value('m_title','users.user_info_title')
				->get()
				->id();
			return $this;
		}

		public function addLinks(){
			$links_array = array(
				array(
					'link_array'	=> array('link'=>array('users','item','%user_id%'),'query'=>array()),
					'name'			=> 'user_page_link',
					'title'			=> 'users.user_page_link_title',
					'value'			=> 'users.user_page_link_value',
					'icon'			=> 'fa fa-user',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('users','edit','%user_id%'),'query'=>array()),
					'name'			=> 'user_edit_page_link',
					'title'			=> 'users.user_edit_page_title',
					'value'			=> 'users.user_edit_page_value',
					'icon'			=> 'fas fa-pen',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('auth','logout','%csrf_token%'),'query'=>array()),
					'name'			=> 'user_escape_link',
					'title'			=> 'auth.logout_link_title',
					'value'			=> 'auth.logout_link',
					'icon'			=> 'fa fa-sign-out-alt',
					'css_class_icon'=> 'chocolate-icon',
				),
			);
			$insert_request = Database::insert('links');
			foreach($links_array as $link){
				$insert_request->value('l_menu_id',$this->menu_id);
				$insert_request->value('l_link_array',$link['link_array']);
				$insert_request->value('l_name',$link['name']);
				$insert_request->value('l_title',$link['title']);
				$insert_request->value('l_icon',$link['icon']);
				$insert_request->value('l_css_class_icon',$link['css_class_icon']);
				$insert_request = $insert_request->value('l_value',$link['value']);
			}
			$insert_request->get()->id();
		}











	}