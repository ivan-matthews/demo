<?php

	namespace System\Migrations;

	use Core\Classes\Database;
	use Core\Classes\Kernel;
	use Core\Database\Interfaces\Create\Create;

	class CreateTableUserGroups202005211111421590099102{

		public function firstStep(){
			Database::getInstance()
				->dropTable('user_groups');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('user_groups',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();
				$table->varchar('name')->nullable()->unique();
				$table->tinyint('status')->notNull()->defaults(Kernel::STATUS_ACTIVE);
				$table->tinyint('default')->notNull()->defaults(0);
				$table->add_timestamps();
				$table->exec();
			});
			return $this;
		}











	}