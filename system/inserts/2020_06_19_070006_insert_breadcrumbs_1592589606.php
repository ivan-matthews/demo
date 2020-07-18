<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Breadcrumbs_Widget;
	use Core\Classes\Kernel;

	class InsertBreadcrumbs202006190700061592589606{

		private $menu_widget_id;

		public function addWidget(){
			$this->menu_widget_id = Database::insert('widgets')
				->value('class',Breadcrumbs_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/bread_crumbs')
				->get()
				->id();
			return $this;
		}

		public function addBreadcrumbsWidgetToBodyHeaderPosition(){
			Database::insert('widgets_active')
				->value('widget_id',$this->menu_widget_id)
				->value('name','bread_crumbs_header')
				->value('title','home.bread_crumbs_widget_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','body_header')
				->value('ordering',2)
				->value('template','widgets/bread_crumbs')
				->get()
				->id()
			;
			return $this;
		}

		public function addBreadcrumbsWidgetToBodyFooterPosition(){
			Database::insert('widgets_active')
				->value('widget_id',$this->menu_widget_id)
				->value('name','bread_crumbs_bottom')
				->value('title','home.bread_crumbs_widget_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',1)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','body_footer')
				->value('ordering',2)
				->value('template','widgets/bread_crumbs')
				->get()
				->id()
			;
			return $this;
		}











	}