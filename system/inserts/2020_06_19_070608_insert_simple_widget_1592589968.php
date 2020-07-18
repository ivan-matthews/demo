<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Simple_Widget;
	use Core\Classes\Kernel;

	class InsertSimpleWidget202006190706081592589968{

		private $simple_widget_id;

		public function addSimpleWidget(){
			$this->simple_widget_id = Database::insert('widgets')
				->value('class',Simple_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/simple')
				->get()
				->id();
			return $this;
		}

		public function addActiveSimpleWidget(){
			Database::insert('widgets_active')
				->value('widget_id',$this->simple_widget_id)
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
			return $this;
		}











	}