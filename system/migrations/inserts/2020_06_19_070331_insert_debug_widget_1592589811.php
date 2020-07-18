<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Debug_Widget;
	use Core\Classes\Kernel;

	class InsertDebugWidget202006190703311592589811{

		private $debug_widget_id;

		public function addDebugWidget(){
			$this->debug_widget_id = Database::insert('widgets')
				->value('w_class',Debug_Widget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/debug')
				->get()
				->id();
			return $this;
		}

		public function addActiveDebugWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->debug_widget_id)
				->value('wa_name','debug_footer')
				->value('wa_title','home.debug_menu_footer')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','footer')
				->value('wa_ordering',2)
				->value('wa_template','widgets/debug')
				->get()
				->id()
			;
		}










	}