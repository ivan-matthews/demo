<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertCronTaskSitemapGenerateMap202008120943421597265022{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('ct_title','sitemap generate_map')
				->value('ct_description','cron task description')
				->value('ct_class',\Core\Controllers\Sitemap\Cron\Generate_Map::class)
				->value('ct_method','execute')
				->value('ct_params',array())
				->value('ct_period',24 * 60 * 60)	// seconds
				->value('ct_options',array())
				->get();
			return $this;
		}











	}