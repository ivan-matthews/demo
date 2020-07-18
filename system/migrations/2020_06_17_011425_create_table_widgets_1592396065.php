<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableWidgets202006170114251592396065{

		public function firstStep(){
			Database::getInstance()
				->dropTable('widgets');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('widgets',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->varchar('class')->nullable();
				$table->varchar('method')->nullable();
				$table->varchar('status')->nullable()->defaults(Kernel::STATUS_ACTIVE);
				$table->varchar('template')->nullable();

				$table->add_timestamps();
			});
			return $this;
		}











	}