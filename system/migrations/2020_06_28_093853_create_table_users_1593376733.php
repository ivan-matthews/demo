<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableUsers202006280938531593376733{

		public function firstStep(){
			Database::getInstance()
				->dropTable('users');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('users',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();
				$table->bigint('auth_id')->unsigned()->notNull();

				$table->varchar('first_name')->nullable();
				$table->varchar('last_name')->nullable();
				$table->varchar('full_name')->nullable();
				$table->varchar('gender')->nullable();
				$table->varchar('avatar_id')->nullable();
				$table->varchar('status_id')->nullable();
				$table->varchar('country_id')->nullable();
				$table->varchar('city_id')->nullable();
				$table->int('birth_day',2)->nullable();
				$table->int('birth_month',2)->nullable();
				$table->int('birth_year',4)->nullable();

				$table->varchar('family')->nullable();
				$table->varchar('phone',20)->nullable();
				$table->varchar('cophone',20)->nullable();
				$table->varchar('email')->nullable();
				$table->varchar('icq')->nullable();
				$table->varchar('skype')->nullable();
				$table->varchar('viber')->nullable();
				$table->varchar('whatsapp')->nullable();
				$table->varchar('telegram')->nullable();
				$table->varchar('website')->nullable();

				$table->longtext('activities')->nullable();
				$table->longtext('interests')->nullable();
				$table->longtext('music')->nullable();
				$table->longtext('films')->nullable();
				$table->longtext('shows')->nullable();
				$table->longtext('books')->nullable();
				$table->longtext('games')->nullable();
				$table->longtext('citates')->nullable();
				$table->longtext('about')->nullable();

				$table->bigint('date_log')->nullable();
				$table->bigint('date_reg')->nullable();
				$table->varchar('log_type')->defaults('w');

				$table->smallint('status',1)->notNull()->defaults(Kernel::STATUS_LOCKED);

				$table->add_timestamps();
			});
			return $this;
		}











	}