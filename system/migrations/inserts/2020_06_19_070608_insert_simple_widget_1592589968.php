<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Simple_Widget;
	use Core\Classes\Kernel;

	class InsertSimpleWidget202006190706081592589968{

		private $simple_widget_id;

		public function addSimpleWidget(){
			$this->simple_widget_id = Database::insert('widgets')
				->value('w_class',Simple_Widget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/simple')
				->get()
				->id();
			return $this;
		}

		public function addActiveSimpleWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->simple_widget_id)
				->value('wa_name','simple_footer')
				->value('wa_title','home.simple_footer_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_INACTIVE)
				->value('wa_position','footer')
				->value('wa_ordering',3)
				->value('wa_template','widgets/simple')
				->get()
				->id()
			;
			return $this;
		}











	}