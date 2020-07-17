<?php

	namespace System\Migrations;

	use Core\Classes\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class __class_name__{

		public function firstStep(){
			Database::getInstance()
				->dropTable('__table_name__');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('__table_name__',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->add_timestamps();
			});
			return $this;
		}











	}