<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableMenu202006170258261592402306{

		public function firstStep(){
			Database::getInstance()
				->dropTable('menu');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('menu',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();
				$table->bigint('widget_id')->unsigned()->nullable();
				$table->varchar('name')->notNull()->unique();
				$table->varchar('title')->nullable();
				$table->int('status')->notNull()->defaults(Kernel::STATUS_ACTIVE);
				$table->add_timestamps();
			});
			return $this;
		}











	}