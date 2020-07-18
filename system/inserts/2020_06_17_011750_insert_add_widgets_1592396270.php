<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertAddWidgets202006170117501592396270{

		public function firstStep(){

			$class = 'Core\\Controllers\\Home\\Widgets\\Home_Menu_Widget';
			$method = 'run';
			$hash = md5($class.$method);

			Database::insert('widgets')
				->value('hash',$hash)
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
		}











	}