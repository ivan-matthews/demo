<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertUsersUpdateBotCronTask202007121203541594551834{

		public function firstStep(){
			Database::insert('cron_tasks')
				->value('ct_title','users update_bot')
				->value('ct_description','cron task description')
				->value('ct_class',"System\\Cron_Tasks\\Users\\Update_Bot")
				->value('ct_method','execute')
				->value('ct_params',array())
				->value('ct_period',850)		// seconds
				->value('ct_options',array())
				->get();
			return $this;
		}











	}