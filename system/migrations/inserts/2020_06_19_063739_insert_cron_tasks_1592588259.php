<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertCronTasks202006190637391592588259{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('ct_title','home remove_old_sessions')
				->value('ct_description','remove old session files')
				->value('ct_class',"System\\Cron_Tasks\\Home\\Remove_Old_Sessions")
				->value('ct_method','execute')
				->value('ct_params',array())
				->value('ct_period',5)		// seconds
				->value('ct_status',Kernel::STATUS_ACTIVE)
				->value('ct_options',array())
				->get();
		}











	}