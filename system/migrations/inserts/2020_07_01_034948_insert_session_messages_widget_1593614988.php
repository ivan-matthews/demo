<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Session_Messages_Widget;
	use Core\Classes\Kernel;

	class InsertSessionMessagesWidget202007010349481593614988{

		private $widget_id;

		public function addWidget(){
			$this->widget_id = Database::insert('widgets')
				->value('w_class',Session_Messages_Widget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/session_messages')
				->get()
				->id();
			return $this;
		}

		public function addAciveWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->widget_id)
				->value('wa_name','session_messages')
				->value('wa_title','home.session_messages_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','top')
				->value('wa_ordering',1)
				->value('wa_template','widgets/session_messages')
				->get()
				->id();
			return $this;
		}











	}