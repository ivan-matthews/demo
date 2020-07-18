<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\Home\Widgets\Menu_Widget;

	class InsertAddWidgets202006170117501592396270{

		public function firstStep(){

			$class = Menu_Widget::class;
			$method = 'run';

			$menu_widget_id = Database::insert('widgets')
				->value('class',$class)
				->value('method',$method)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/menu')
				->get()
				->id();

			Database::insert('widgets_active')
				->value('widget_id',$menu_widget_id)
				->value('name','guest_menu')
				->value('title','auth.guest_menu_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','sidebar')
				->value('ordering',2)
				->value('template','widgets/menu')
				->value('groups_enabled',array(0))
				->get()
				->id()
			;
			Database::insert('widgets_active')
				->value('widget_id',$menu_widget_id)
				->value('name','user_menu')
				->value('title','auth.user_menu_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','sidebar')
				->value('ordering',2)
				->value('template','widgets/menu')
				->value('groups_disabled',array(0))
				->get()
				->id()
			;
			Database::insert('widgets_active')
				->value('widget_id',$menu_widget_id)
				->value('name','main_menu')
				->value('title','home.main_menu_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','sidebar')
				->value('ordering',1)
				->value('template','widgets/menu')
				->get()
				->id()
			;

			return $this;
		}











	}