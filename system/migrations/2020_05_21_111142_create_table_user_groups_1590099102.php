<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableUserGroups202005211111421590099102{

		public function firstStep(){
			Database::getInstance()
				->dropTable('user_groups');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('user_groups',function(Create $table){
				$table->bigint('ug_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('ug_name')->nullable()->unique();
				$table->tinyint('ug_status')->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->tinyint('ug_default')->notNull()->defaults(0)->index();

				$table->add_timestamps('ug_');
			});
			return $this;
		}











	}