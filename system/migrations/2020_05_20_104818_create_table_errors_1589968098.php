<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableErrors202005201048181589968098{

		public function firstStep(){
			Database::getInstance()
				->dropTable('errors');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('errors',function(Create $table){
				$table->bigint('e_id')->unsigned()->autoIncrement()->primary();
				$table->varchar('e_hash')->nullable()->unique();
				$table->bigint('e_count')->unsigned()->notNull()->defaults(0);
				$table->varchar('e_number')->nullable();
				$table->varchar('e_file',1024)->nullable();
				$table->varchar('e_line')->nullable();
				$table->longtext('e_message');
				$table->longtext('e_backtrace');
				$table->longtext('e_msg');

				$table->add_timestamps('e_');
			});
			return $this;
		}











	}