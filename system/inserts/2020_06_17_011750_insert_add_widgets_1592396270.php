<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\Home\Widgets\Menu_Widget;

	class InsertAddWidgets202006170117501592396270{

		public function firstStep(){

			$class = Menu_Widget::class;
			$method = 'run';

			Database::insert('widgets')
				->value('class',$class)
				->value('method',$method)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','sidebar')
				->value('template','widgets/menu')
				->value('groups_enabled',null)
				->value('groups_disabled',null)
				->value('pages_enabled',null)
				->value('pages_disabled',null)
				->get()
				->id();
			Database::insert('widgets')
				->value('class',$class)
				->value('method',$method)
				->value('status',Kernel::STATUS_ACTIVE)
				->value('position','sidebar')
				->value('template','widgets/menu')
				->value('groups_enabled',null)
				->value('groups_disabled',null)
				->value('pages_enabled',null)
				->value('pages_disabled',null)
				->get()
				->id();
			return $this;
		}











	}