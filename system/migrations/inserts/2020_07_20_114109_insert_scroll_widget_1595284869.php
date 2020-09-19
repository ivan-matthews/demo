<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Widgets\Scroll;

	class InsertScrollWidget202007201141091595284869{

		private $simple_widget_id;

		public function addScrollWidget(){
			$this->simple_widget_id = Database::insert('widgets')
				->value('w_class',Scroll::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/scroll')
				->get()
				->id();
			return $this;
		}

		public function activateScrollWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->simple_widget_id)
				->value('wa_name','scroll_widget')
				->value('wa_title','home.scroll_widget_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','sidebar')
				->value('wa_ordering',4)
				->value('wa_template','widgets/scroll')
				->get()
				->id()
			;
			return $this;
		}










	}