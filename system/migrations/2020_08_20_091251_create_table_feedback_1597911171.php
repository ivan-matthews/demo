<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableFeedback202008200912511597911171{

		public function firstStep(){
			Database::getInstance()
				->dropTable('feedback');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('feedback',function(Create $table){
				$table->bigint('fb_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('fb_name')->notNull()->index();
				$table->varchar('fb_phone')->notNull()->index();
				$table->varchar('fb_email')->notNull()->index();
				$table->longtext('fb_content')->notNull()->fullText();
				$table->longtext('fb_answer')->nullable()->fullText();
				$table->tinyint('fb_status')->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('fb_');
			});
			return $this;
		}











	}