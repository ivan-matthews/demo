<?php

/*
	select distinct messages.m_sender_id,users.*,photos.*,
		(select (count(*)) from messages where m_sender_id=u_id and m_user_id='{$user_id}') as total	// ???
		from
			`messages`
		left join users force index(primary)
			on m_sender_id=u_id
		left join photos force index(primary)
			on m_user_id=p_user_id
		where
			m_user_id='{$user_id}'

	то есть таблицу контактов пока что создавать не будем. тест*
*/

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableMessages202007300849131596138553{

		public function firstStep(){
			Database::getInstance()
				->dropTable('messages');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('messages',function(Create $table){
				$table->bigint('m_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('m_contact_id')->nullable()->index();
				$table->bigint('m_sender_id')->nullable()->index();
				$table->bigint('m_receiver_id')->nullable()->index();

				$table->longtext('m_content')->nullable()->fullText();

				$table->tinyint('m_hide_in_user')->nullable()->index();
				$table->tinyint('m_hide_in_sender')->nullable()->index();
				$table->tinyint('m_status')->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->tinyint( "m_readed")->nullable()->index();

				$table->add_timestamps('m_');
			});
			return $this;
		}











	}