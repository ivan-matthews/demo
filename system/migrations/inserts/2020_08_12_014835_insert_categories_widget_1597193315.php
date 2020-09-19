<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\Categories\Widgets\Categories;

	class InsertCategoriesWidget202008120148351597193315{

		private $cats_widget;

		public function addCategoriesWidget(){
			$this->cats_widget = Database::insert('widgets')
				->value('w_class',Categories::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/categories/widgets/categories')
				->get()
				->id();
			return $this;
		}

		public function activateCategoriesWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->cats_widget)
				->value('wa_name','categories_widget')
				->value('wa_title','cats.categories_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','sidebar')
				->value('wa_ordering',6)
				->value('wa_template','controllers/categories/widgets/categories')
				->value('wa_pages_enabled',array(
					'blog'	=> array(),
					'faq'	=> array(),
				))
				->get()
				->id()
			;
			return $this;
		}











	}