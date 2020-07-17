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
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->varchar('hash')->nullable()->unique();
				$table->bigint('count')->unsigned()->notNull()->defaults(0);
				$table->varchar('number')->nullable();
				$table->varchar('file',1024)->nullable();
				$table->varchar('line')->nullable();

				$table->longtext('message');
				$table->longtext('backtrace');
				$table->longtext('msg');

				$table->add_timestamps();
			});
			return $this;
		}











	}