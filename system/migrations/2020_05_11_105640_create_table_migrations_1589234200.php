<?php

	namespace System\Migrations;

	use Core\Classes\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableMigrations202005111056401589234200{

		public function firstStep(){
			Database::getInstance()
				->dropTable('migrations');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('migrations',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();
				$table->varchar('name')->bin()->unique();
				$table->timestamp('date_created')->currentTimestamp();
				$table->exec();
			});
			return $this;
		}











	}