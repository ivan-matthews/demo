<?php

	namespace System\Inserts;

	use Core\Classes\Database;
	use Core\Classes\Kernel;

	class AddHomeTestCronTask00000000{

		public function first(){
			Database::insert('cron_tasks')
				->value('title','home test')
				->value('description','runt first testing cron task')
				->value('class',"System\\Cron_Tasks\\Home\\Test")
				->value('method','execute')
				->value('params',array())
				->value('period',5)		// seconds
				->value('status',Kernel::STATUS_ACTIVE)
				->value('options',array())
				->get();
			return $this;
		}

	}
