<?php

	namespace System\Migrations;

	use Core\Classes\Database;
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
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->varchar('title')->nullable()->index();
				$table->longtext('description');
				$table->varchar('class')->nullable()->index();
				$table->varchar('method')->notNull()->defaults('execute');
				$table->varchar('params')->notNull()->defaults('[]');
				$table->varchar('period')->notNull()->defaults('3600'); // seconds
				$table->tinyint('status',2)->notNull()->defaults(Kernel::STATUS_ACTIVE);
				$table->longtext('options');
				$table->longtext('errors');
				$table->longtext('result');

				$table->add_timestamps();
				$table->exec();
			});
			return $this;
		}











	}