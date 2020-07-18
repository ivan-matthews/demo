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
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->varchar('login')->notNull()->unique();
				$table->varchar('password')->notNull();
				$table->longtext('enc_password')->notNull();
				$table->longtext('groups')->notNull();

				$table->varchar('bookmark')->bin()->unique();
				$table->varchar('verify_token')->bin()->unique();
				$table->varchar('restore_login_token')->bin()->unique();
				$table->varchar('restore_password_token')->bin()->unique();

				$table->smallint('status',1)->notNull()->defaults(Kernel::STATUS_LOCKED);

				$table->bigint('date_login_restore')->nullable();
				$table->bigint('date_password_restore')->nullable();
				$table->bigint('date_activate')->nullable();

				$table->add_timestamps();
			});
			return $this;
		}











	}