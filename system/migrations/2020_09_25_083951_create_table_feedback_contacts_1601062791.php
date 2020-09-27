<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableFeedbackContacts202009250839511601062791{

		public function firstStep(){
			Database::getInstance()
				->dropTable('feedback_contacts');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('feedback_contacts',function(Create $table){
				$table->bigint('fc_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('fc_operator_id')->unsigned()->nullable()->index();
				$table->varchar('fc_title')->nullable()->index();
				$table->longtext('fc_description')->nullable()->fullText();

				$table->varchar('fc_street')->nullable()->index();
				$table->varchar('fc_house')->nullable()->index();
				$table->varchar('fc_apartments')->nullable()->index();

				$table->tinyint('fc_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('fc_');
			});
			return $this;
		}











	}