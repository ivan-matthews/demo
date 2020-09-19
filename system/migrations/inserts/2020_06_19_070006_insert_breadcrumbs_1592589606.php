<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Breadcrumbs_Widget;
	use Core\Classes\Kernel;

	class InsertBreadcrumbs202006190700061592589606{

		private $menu_widget_id;

		public function addWidget(){
			$this->menu_widget_id = Database::insert('widgets')
				->value('w_class',Breadcrumbs_Widget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/bread_crumbs')
				->get()
				->id();
			return $this;
		}

		public function addBreadcrumbsWidgetToBodyHeaderPosition(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->menu_widget_id)
				->value('wa_name','bread_crumbs_header')
				->value('wa_title','home.bread_crumbs_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','body_header')
				->value('wa_ordering',2)
				->value('wa_template','widgets/bread_crumbs')
				->get()
				->id()
			;
			return $this;
		}

		public function addBreadcrumbsWidgetToBodyFooterPosition(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->menu_widget_id)
				->value('wa_name','bread_crumbs_bottom')
				->value('wa_title','home.bread_crumbs_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','body_footer')
				->value('wa_ordering',2)
				->value('wa_template','widgets/bread_crumbs')
				->get()
				->id()
			;
			return $this;
		}











	}