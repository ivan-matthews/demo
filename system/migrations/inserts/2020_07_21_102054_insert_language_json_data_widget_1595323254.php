<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Widgets\Language;

	class InsertLanguageJsonDataWidget202007211020541595323254{

		private $simple_widget_id;

		public function addLanguageWidget(){
			$this->simple_widget_id = Database::insert('widgets')
				->value('w_class',Language::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','widgets/language')
				->get()
				->id();
			return $this;
		}

		public function activateLanguageWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->simple_widget_id)
				->value('wa_name','language_widget')
				->value('wa_title','home.language_widget_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',0)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','footer')
				->value('wa_ordering',4)
				->value('wa_template','widgets/language')
				->get()
				->id()
			;
			return $this;
		}











	}