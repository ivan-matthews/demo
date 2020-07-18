<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Widgets\Session_Messages_Widget;
	use Core\Classes\Kernel;

	class InsertSessionMessagesWidget202007010349481593614988{

		private $widget_id;

		public function addWidget(){
			$this->widget_id = Database::insert('widgets')
				->value('class',Session_Messages_Widget::class)
				->value('method','run')
				->value('status',Kernel::STATUS_ACTIVE)
				->value('template','widgets/session_messages')
				->get()
				->id();
			return $this;
		}

		public function addAciveWidget(){
			Database::insert('widgets_active')
				->value('widget_id',$this->widget_id)
				->value('name','session_messages')
				->value('title','home.session_messages_title')
				->value('css_class','')
				->value('css_class_title','')
				->value('css_class_body','')
				->value('show_title',0)
				->value('unite_prev',0)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','top')
				->value('ordering',1)
				->value('template','widgets/session_messages')
				->get()
				->id();
			return $this;
		}











	}