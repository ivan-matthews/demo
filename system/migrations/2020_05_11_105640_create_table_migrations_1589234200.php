<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableMigrations202005111056401589234200{

		public function firstStep(){
			Database::getInstance()
				->dropTable('migrations');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('migrations',function(Create $table){
				$table->bigint('mg_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('mg_name')->bin()->unique();
				$table->timestamp('mg_date_created')->currentTimestamp()->index();
			});
			return $this;
		}











	}