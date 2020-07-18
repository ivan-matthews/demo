<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Debug_Widget;
	use Core\Classes\Kernel;

	class InsertDebugWidget202006190703311592589811{

		private $debug_widget_id;

		public function addDebugWidget(){
			$this->debug_widget_id = Database::insert('widgets')
				->value('class',Debug_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/debug')
				->get()
				->id();
			return $this;
		}

		public function addActiveDebugWidget(){
			Database::insert('widgets_active')
				->value('widget_id',$this->debug_widget_id)
				->value('name','debug_footer')
				->value('title','home.debug_menu_footer')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',0)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','footer')
				->value('ordering',2)
				->value('template','widgets/debug')
				->get()
				->id()
			;
		}










	}