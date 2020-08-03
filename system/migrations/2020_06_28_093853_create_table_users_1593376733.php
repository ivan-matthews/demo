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
				$table->bigint('u_auth_id')->unsigned()->notNull()->index();

				$table->varchar('u_first_name')->nullable()->index();
				$table->varchar('u_last_name')->nullable()->index();
				$table->varchar('u_full_name')->nullable()->index();
				$table->smallint('u_gender')->notNull()->defaults(User::GENDER_NONE)->index();
				$table->varchar('u_avatar_id')->nullable()->index();
				$table->varchar('u_status_id')->nullable()->index();
				$table->bigint('u_country_id')->unsigned()->nullable()->index();
				$table->bigint('u_region_id')->unsigned()->nullable()->index();
				$table->bigint('u_city_id')->unsigned()->nullable()->index();
				$table->int('u_birth_day',2)->nullable()->index();
				$table->int('u_birth_month',2)->nullable()->index();
				$table->int('u_birth_year',4)->nullable()->index();

				$table->varchar('u_family')->nullable()->index();
				$table->varchar('u_phone',20)->nullable()->index();
				$table->varchar('u_cophone',20)->nullable()->index();
				$table->varchar('u_email')->nullable()->index();
				$table->varchar('u_icq')->nullable()->index();
				$table->varchar('u_skype')->nullable()->index();
				$table->varchar('u_viber')->nullable()->index();
				$table->varchar('u_whatsapp')->nullable()->index();
				$table->varchar('u_telegram')->nullable()->index();
				$table->varchar('u_website')->nullable()->index();

				$table->longtext('u_activities')->nullable()->fullText();
				$table->longtext('u_interests')->nullable()->fullText();
				$table->longtext('u_music')->nullable()->fullText();
				$table->longtext('u_films')->nullable()->fullText();
				$table->longtext('u_shows')->nullable()->fullText();
				$table->longtext('u_books')->nullable()->fullText();
				$table->longtext('u_games')->nullable()->fullText();
				$table->longtext('u_citates')->nullable()->fullText();
				$table->longtext('u_about')->nullable()->fullText();

				$table->smallint('u_status',1)->notNull()->defaults(Kernel::STATUS_LOCKED)->index();
				$table->smallint('u_log_type',1)->defaults(User::LOGGED_DEFAULT)->index();
				$table->smallint('u_user_type',1)->notNull()->defaults(1)->index();	// 1 | 2 - user|bot

				$table->bigint('u_date_log')->nullable()->index();

				$table->add_timestamps('u_');
			});
			return $this;
		}











	}