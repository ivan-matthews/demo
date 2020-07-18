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
				$table->bigint('w_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('w_class')->nullable();
				$table->varchar('w_method')->nullable();
				$table->varchar('w_status')->nullable()->defaults(Kernel::STATUS_ACTIVE);
				$table->varchar('w_template')->nullable();

				$table->add_timestamps('w_');
			});
			return $this;
		}











	}