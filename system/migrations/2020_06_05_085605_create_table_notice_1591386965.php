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
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->tinyint('status',2)->notNull()->defaults(Notice::STATUS_DEFAULT);
				$table->varchar('theme')->nullable();
				$table->varchar('sender_id')->nullable();
				$table->varchar('receiver_id')->nullable();
				$table->varchar('content')->nullable();
				$table->longtext('attachments')->nullable();
				$table->longtext('options')->nullable();

				$table->add_timestamps();
			});
			return $this;
		}











	}