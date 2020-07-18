<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertCronTasks202006190637391592588259{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('title','home remove_old_sessions')
				->value('description','remove old session files')
				->value('class',"System\\Cron_Tasks\\Home\\Remove_Old_Sessions")
				->value('method','execute')
				->value('params',array())
				->value('period',5)		// seconds
				->value('status',Kernel::STATUS_ACTIVE)
				->value('options',array())
				->get();
		}











	}