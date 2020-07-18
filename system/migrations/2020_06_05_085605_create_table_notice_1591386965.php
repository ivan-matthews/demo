<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Mail\Notice;

	class CreateTableNotice202006050856051591386965{

		public function firstStep(){
			Database::getInstance()
				->dropTable('notice');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('notice',function(Create $table){
				$table->bigint('n_id')->unsigned()->autoIncrement()->primary();

				$table->tinyint('n_status',2)->notNull()->defaults(Notice::STATUS_DEFAULT);
				$table->varchar('n_theme')->nullable();
				$table->varchar('n_sender_id')->nullable();
				$table->varchar('n_receiver_id')->nullable();
				$table->varchar('n_content')->nullable();
				$table->longtext('n_attachments')->nullable();
				$table->longtext('n_options')->nullable();

				$table->add_timestamps('n_');
			});
			return $this;
		}











	}