<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;	
	use Core\Classes\Kernel;	
	use Core\Controllers\News\Cron\Parse_Gazeta_Ua;

	class InsertCronTaskNewsParseGazetaUa202010040502441601827364{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('ct_title','news parse_gazeta_ua')
				->value('ct_description','news parse_gazeta_ua cron task action')
				->value('ct_class',Parse_Gazeta_Ua::class)
				->value('ct_method','execute')
				->value('ct_status',Kernel::STATUS_INACTIVE)
				->value('ct_params',array())
				->value('ct_period',60*5)	// seconds
				->value('ct_options',array())
				->get();
			return $this;
		}











	}
