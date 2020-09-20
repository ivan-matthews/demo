<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class AddHomeTestCronTask00000000{

		public function first(){
			Database::insert('cron_tasks')
				->value('ct_title','home test')
				->value('ct_description','runt first testing cron task')
				->value('ct_class',\Core\Controllers\Home\Cron\Test::class)
				->value('ct_method','execute')
				->value('ct_params',array())
				->value('ct_period',5)		// seconds
				->value('ct_status',Kernel::STATUS_ACTIVE)
				->value('ct_options',array())
				->get();
			return $this;
		}

	}
