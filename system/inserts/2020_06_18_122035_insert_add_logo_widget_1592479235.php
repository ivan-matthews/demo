<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Widgets\Simple_Widget;

	class InsertAddLogoWidget202006181220351592479235{

		public function firstStep(){
			$logo_widget_id = Database::insert('widgets')
				->value('class',Simple_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/simple')
				->get()
				->id();

			Database::insert('widgets_active')
				->value('widget_id',$logo_widget_id)
				->value('name','site_logo')
				->value('title','home.site_logo_widget_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','header')
				->value('ordering',1)
				->value('template','widgets/logo')
				->get()
				->id()
			;
			Database::insert('widgets_active')
				->value('widget_id',$logo_widget_id)
				->value('name','simple_footer')
				->value('title','home.simple_footer_widget_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_INACTIVE)
				->value('position','footer')
				->value('ordering',1)
				->value('template','widgets/simple')
				->get()
				->id()
			;
			Database::insert('widgets_active')
				->value('widget_id',$logo_widget_id)
				->value('name','debug_footer')
				->value('title','home.debug_menu_footer')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','footer')
				->value('ordering',1)
				->value('template','widgets/debug')
				->get()
				->id()
			;
			return $this;
		}











	}