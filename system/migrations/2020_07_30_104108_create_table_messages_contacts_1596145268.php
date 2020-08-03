<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableMessagesContacts202007301041081596145268{

		public function firstStep(){
			Database::getInstance()
				->dropTable('messages_contacts');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('messages_contacts',function(Create $table){
				$table->bigint('mc_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('mc_sender_id')->nullable()->index();
				$table->bigint('mc_user_id')->nullable()->index();
				$table->bigint('mc_last_message_id')->nullable()->index();

				$table->tinyint('mc_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('mc_');
			});
			return $this;
		}











	}