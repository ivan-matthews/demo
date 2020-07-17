<?php

	namespace System\Migrations;

	use Core\Classes\Database;
	use Core\Database\Create;

	class CreateTableUsers202005120807211589310441{

		public function firstStep(){
			Database::getInstance()
				->dropTable('users');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('users',function(Create $table){
				/*
					$table->bigint('id')->unsigned()->primary()->autoIncrement();

					$table->varchar('first_name')->index()->nullable();
					$table->varchar('phone',20)->index()->nullable();
					$table->int('birth_day',2)->index()->nullable();
					$table->longtext('activities')->fullText()->nullable();
					$table->bigint('date_log')->index()->nullable();
					$table->varchar('log_type')->index()->nullable();
					$table->varchar('type')->index()->defaults('u');

					$table->add_timestamps(); // added fields `date_created`, `date_updated`, `date_deleted`
					$table->exec();
				*/
			});
			return $this;
		}











	}