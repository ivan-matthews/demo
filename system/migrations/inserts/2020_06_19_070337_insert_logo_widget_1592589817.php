<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Logo_Widget;
	use Core\Classes\Kernel;

	class InsertLogoWidget202006190703371592589817{

		private $logo_widget_id;

		public function addLogoWidget(){
			$this->logo_widget_id = Database::insert('widgets')
				->value('w_class',Logo_Widget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/logo')
				->get()
				->id();
			return $this;
		}

		public function addActiveLogoWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->logo_widget_id)
				->value('wa_name','site_logo')
				->value('wa_title','home.site_logo_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','header')
				->value('wa_ordering',1)
				->value('wa_template','widgets/logo')
				->get()
				->id()
			;
			return $this;
		}











	}