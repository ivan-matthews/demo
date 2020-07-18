<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\Home\Widgets\Menu_Widget;

	class InsertWidgetMenu202006190639001592588340{

		private $class;
		private $method;
		private $menu_widget_id;

		private $main_menu_id;
		private $user_menu_id;
		private $guest_menu_id;
		private $info_menu_id;

		private $user_menu;
		private $guest_menu;
		private $main_menu;
		private $info_menu;

		public function __construct(){
			$this->class = Menu_Widget::class;
			$this->method = 'run';
		}

		public function addWidget(){
			$this->menu_widget_id = Database::insert('widgets')
				->value('w_class',$this->class)
				->value('w_method',$this->method)
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/menu')
				->get()
				->id();
			return $this;
		}

		public function addActiveWidgetGuestMenu(){
			$this->guest_menu_id = Database::insert('widgets_active')
				->value('wa_widget_id',$this->menu_widget_id)
				->value('wa_name','guest_menu')
				->value('wa_title','auth.guest_menu_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','sidebar')
				->value('wa_ordering',3)
				->value('wa_template','widgets/menu')
				->value('wa_groups_enabled',array(0))
				->get()
				->id()
			;
			return $this;
		}

		public function addActiveWidgetUserMenu(){
			$this->user_menu_id = Database::insert('widgets_active')
					->value('wa_widget_id',$this->menu_widget_id)
					->value('wa_name','user_menu')
					->value('wa_title','auth.user_menu_title')
					->value('wa_css_class','')
					->value('wa_css_class_title','')
					->value('wa_css_class_body','')
					->value('wa_show_title',1)
					->value('wa_unite_prev',0)
					->value('wa_status',Kernel::STATUS_INACTIVE)
					->value('wa_position','sidebar')
					->value('wa_ordering',2)
					->value('wa_template','widgets/menu')
					->value('wa_groups_disabled',array(0))
					->get()
					->id()
			;
			return $this;
		}

		public function addActiveWidgetMainMenu(){
			$this->main_menu_id = Database::insert('widgets_active')
				->value('wa_widget_id',$this->menu_widget_id)
				->value('wa_name','main_menu')
				->value('wa_title','home.main_menu_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','sidebar')
				->value('wa_ordering',1)
				->value('wa_template','widgets/menu')
				->get()
				->id()
			;
			return $this;
		}

		public function addActiveWidgetInfoMenu(){
			$this->info_menu_id = Database::insert('widgets_active')
				->value('wa_widget_id',$this->menu_widget_id)
				->value('wa_name','info_menu')
				->value('wa_title','home.info_menu_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','footer')
				->value('wa_ordering',1)
				->value('wa_template','widgets/info')
				->get()
				->id()
			;
		}

		public function addUserMenu(){
			$this->user_menu = Database::insert('menu')
				->value('m_widget_id',$this->user_menu_id)
				->value('m_name','user_menu')
				->value('m_title','auth.user_menu_title')
				->get()
				->id();
			return $this;
		}

		public function addGuestMenu(){
			$this->guest_menu = Database::insert('menu')
				->value('m_widget_id',$this->guest_menu_id)
				->value('m_name','guest_menu')
				->value('m_title','auth.guest_menu_title')
				->get()
				->id();
			return $this;
		}

		public function addMainMenu(){
			$this->main_menu = Database::insert('menu')
				->value('m_widget_id',$this->main_menu_id)
				->value('m_name','main_menu')
				->value('m_title','home.main_menu_title')
				->get()
				->id();
			return $this;
		}

		public function addInfoMenu(){
			$this->info_menu = Database::insert('menu')
				->value('m_widget_id',$this->info_menu_id)
				->value('m_name','info_menu')
				->value('m_title','home.info_menu_title')
				->get()
				->id();
			return $this;
		}

		public function addLinksToUserGuestMainMenu(){
			$links_array = array(
				array(
					'menu_id'		=> $this->main_menu,
					'link_array'	=> array(
						'link'=>array(

						),
						'query'=>array(

						)
					),
					'name'			=> 'home_page',
					'title'			=> 'home.home_link_title',
					'value'			=> 'home.home_link',
				),
				array(
					'menu_id'		=> $this->main_menu,
					'link_array'	=> array(
						'link'=>array(
							'users','index'
						),
						'query'=>array(

						)
					),
					'name'			=> 'users_page',
					'title'			=> 'users.users_link_title',
					'value'			=> 'users.users_link_value',
				),
				array(
					'menu_id'		=> $this->guest_menu,
					'link_array'	=> array(
						'link'=>array(
							'auth','index'
						),
						'query'=>array(

						)
					),
					'name'			=> 'auth_page',
					'title'			=> 'auth.auth_link_title',
					'value'			=> 'auth.auth_link',
				),
				array(
					'menu_id'		=> $this->guest_menu,
					'link_array'	=> array(
						'link'=>array(
							'auth','registration'
						),
						'query'=>array(

						)
					),
					'name'			=> 'auth_sign_up',
					'title'			=> 'auth.registration_link_title',
					'value'			=> 'auth.registration_link',
				),
				array(
					'menu_id'		=> $this->user_menu,
					'link_array'	=> array(
						'link'=>array(
							'auth','logout','%csrf_token%'
						),
						'query'=>array()
					),
					'name'			=> 'auth_log_out',
					'title'			=> 'auth.logout_link_title',
					'value'			=> 'auth.logout_link',
				)
			);
			$insert_request = Database::insert('links');
			foreach($links_array as $link){
				$insert_request->value('l_menu_id',$link['menu_id']);
				$insert_request->value('l_link_array',$link['link_array']);
				$insert_request->value('l_name',$link['name']);
				$insert_request->value('l_title',$link['title']);
				$insert_request = $insert_request->value('l_value',$link['value']);
			}
			$insert_request->get()->id();
		}

		public function addLinksToInfoMenu(){
			$links_array = array(
				array(
					'link_array'	=> array('link'=>array('rules'),'query'=>array()),
					'name'			=> 'rules_page',
					'title'			=> 'home.rules_link_title',
					'value'			=> 'home.rules_link_value',
					'icon'			=> 'fa fa-gavel',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('faq'),'query'=>array()),
					'name'			=> 'faq_page',
					'title'			=> 'home.faq_link_title',
					'value'			=> 'home.faq_link_value',
					'icon'			=> 'fa fa-question',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array(
						'help'
					),
					'name'			=> 'help_page',
					'title'			=> 'home.help_link_title',
					'value'			=> 'home.help_link_value',
					'icon'			=> 'fa fa-medkit',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('help'),'query'=>array()),
					'name'			=> 'support_page',
					'title'			=> 'home.support_link_title',
					'value'			=> 'home.support_link_value',
					'icon'			=> 'fa fa-life-ring',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('feedback'),'query'=>array()),
					'name'			=> 'feedback_page',
					'title'			=> 'home.feedback_link_title',
					'value'			=> 'home.feedback_link_title',
					'icon'			=> 'fa fa-comments',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('blog'),'query'=>array()),
					'name'			=> 'blog_page',
					'title'			=> 'home.blog_link_title',
					'value'			=> 'home.blog_link_title',
					'icon'			=> 'fa fa-newspaper',
					'css_class_icon'=> 'chocolate-icon',
				),
				array(
					'link_array'	=> array('link'=>array('sitemap'),'query'=>array()),
					'name'			=> 'sitemap_page',
					'title'			=> 'home.sitemap_link_title',
					'value'			=> 'home.sitemap_link_title',
					'icon'			=> 'fa fa-sitemap',
					'css_class_icon'=> 'chocolate-icon',
				),
			);
			$insert_request = Database::insert('links');
			foreach($links_array as $link){
				$insert_request->value('l_menu_id',$this->info_menu);
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