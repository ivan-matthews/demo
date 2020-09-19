<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableCronTasks202005201126201589970380{

		public function firstStep(){
			Database::getInstance()
				->dropTable('cron_tasks');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('cron_tasks',function(Create $table){
				$table->bigint('ct_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('ct_title')->nullable()->index();
				$table->varchar('ct_class')->nullable()->index();
				$table->varchar('ct_method')->notNull()->defaults('execute')->index();
				$table->varchar('ct_params')->notNull()->defaults('[]')->index();
				$table->varchar('ct_period')->notNull()->defaults(3600)->index(); // seconds
				$table->tinyint('ct_status',2)->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->longtext('ct_description')->nullable()->fullText();
				$table->longtext('ct_options')->nullable()->fullText();
				$table->longtext('ct_errors')->nullable()->fullText();
				$table->longtext('ct_result')->nullable()->fullText();

				$table->add_timestamps('ct_');
			});
			return $this;
		}











	}