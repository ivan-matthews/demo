<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertCronTaskUsersAddNewBot202007160516501594916210{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('ct_title','users add_new_bot')
				->value('ct_description','cron task description')
				->value('ct_class',\Core\Controllers\Users\Cron\Add_New_Bot::class)
				->value('ct_method','execute')
				->value('ct_params',array())
				->value('ct_period',300)	// seconds
				->value('ct_options',array())
				->get();
			return $this;
		}











	}