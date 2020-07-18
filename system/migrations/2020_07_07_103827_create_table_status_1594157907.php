<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableStatus202007071038271594157907{

		public function firstStep(){
			Database::getInstance()
				->dropTable('status');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('status',function(Create $table){
				$table->bigint('s_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('s_user_id')->nullable();
				$table->varchar('s_status')->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->longtext('s_content')->nullable()->fullText();

				$table->add_timestamps('s_');
			});
			return $this;
		}











	}