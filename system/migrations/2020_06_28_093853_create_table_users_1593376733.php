<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;
	use Core\Classes\User;

	class CreateTableUsers202006280938531593376733{

		public function firstStep(){
			Database::getInstance()
				->dropTable('users');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('users',function(Create $table){
				$table->bigint('u_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('u_auth_id')->unsigned()->notNull();

				$table->varchar('u_first_name')->nullable();
				$table->varchar('u_last_name')->nullable();
				$table->varchar('u_full_name')->nullable();
				$table->smallint('u_gender')->notNull()->defaults(User::GENDER_NONE);
				$table->varchar('u_avatar_id')->nullable();
				$table->varchar('u_status_id')->nullable();
				$table->varchar('u_country_id')->nullable();
				$table->varchar('u_city_id')->nullable();
				$table->int('u_birth_day',2)->nullable();
				$table->int('u_birth_month',2)->nullable();
				$table->int('u_birth_year',4)->nullable();

				$table->varchar('u_family')->nullable();
				$table->varchar('u_phone',20)->nullable();
				$table->varchar('u_cophone',20)->nullable();
				$table->varchar('u_email')->nullable();
				$table->varchar('u_icq')->nullable();
				$table->varchar('u_skype')->nullable();
				$table->varchar('u_viber')->nullable();
				$table->varchar('u_whatsapp')->nullable();
				$table->varchar('u_telegram')->nullable();
				$table->varchar('u_website')->nullable();

				$table->longtext('u_activities')->nullable();
				$table->longtext('u_interests')->nullable();
				$table->longtext('u_music')->nullable();
				$table->longtext('u_films')->nullable();
				$table->longtext('u_shows')->nullable();
				$table->longtext('u_books')->nullable();
				$table->longtext('u_games')->nullable();
				$table->longtext('u_citates')->nullable();
				$table->longtext('u_about')->nullable();

				$table->smallint('u_status',1)->notNull()->defaults(Kernel::STATUS_LOCKED);

				$table->varchar('u_log_type')->defaults(User::LOGGED_DEFAULT);
				$table->bigint('u_date_log')->nullable();

				$table->add_timestamps('u_');
			});
			return $this;
		}











	}