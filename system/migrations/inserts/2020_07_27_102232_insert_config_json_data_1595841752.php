<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Widgets\Config;

	class InsertConfigJsonData202007271022321595841752{

		private $simple_widget_id;

		public function addConfigWidget(){
			$this->simple_widget_id = Database::insert('widgets')
				->value('w_class',Config::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/config')
				->get()
				->id();
			return $this;
		}

		public function activateConfigWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->simple_widget_id)
				->value('wa_name','config_widget')
				->value('wa_title','home.config_widget_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','footer')
				->value('wa_ordering',5)
				->value('wa_template','widgets/config')
				->get()
				->id()
			;
			return $this;
		}











	}