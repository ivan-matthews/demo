<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableAuth202006280942111593376931{

		public function firstStep(){
			Database::getInstance()
				->dropTable('auth');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('auth',function(Create $table){
				$table->bigint('a_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('a_login')->notNull()->unique();
				$table->varchar('a_password')->notNull();
				$table->longtext('a_enc_password')->notNull();
				$table->varchar('a_lang',2)->nullable();
				$table->longtext('a_groups')->notNull();

				$table->varchar('a_bookmark')->bin()->unique();
				$table->varchar('a_verify_token')->bin()->unique();
				$table->varchar('a_restore_login_token')->bin()->unique();
				$table->varchar('a_restore_password_token')->bin()->unique();

				$table->smallint('a_status',1)->notNull()->defaults(Kernel::STATUS_LOCKED);

				$table->bigint('a_date_login_restore')->nullable();
				$table->bigint('a_date_password_restore')->nullable();
				$table->bigint('a_date_activate')->nullable();

				$table->add_timestamps('a_');
			});
			return $this;
		}











	}