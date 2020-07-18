<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Logo_Widget;
	use Core\Classes\Kernel;

	class InsertLogoWidget202006190703371592589817{

		private $logo_widget_id;

		public function addLogoWidget(){
			$this->logo_widget_id = Database::insert('widgets')
				->value('class',Logo_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/logo')
				->get()
				->id();
			return $this;
		}

		public function addActiveLogoWidget(){
			Database::insert('widgets_active')
				->value('widget_id',$this->logo_widget_id)
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
			return $this;
		}











	}