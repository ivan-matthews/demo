<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableFaq202008181013011597785181{

		public function firstStep(){
			Database::getInstance()
				->dropTable('faq');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('faq',function(Create $table){
				$table->bigint('f_id')->unsigned()->autoIncrement()->primary();

				$table->longtext('f_question')->nullable()->fullText();
				$table->longtext('f_answer')->nullable()->fullText();

				$table->bigint('f_category_id')->nullable()->index();
				$table->bigint('f_status')->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('f_');
			});
			return $this;
		}











	}