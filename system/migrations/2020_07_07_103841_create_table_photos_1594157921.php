<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTablePhotos202007071038411594157921{

		public function firstStep(){
			Database::getInstance()
				->dropTable('photos');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('photos',function(Create $table){
				$table->bigint('p_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('p_user_id')->nullable()->index();
				$table->bigint('p_total_comments')->notNull()->defaults(0)->index();
				$table->varchar('p_name')->nullable()->index();
				$table->varchar('p_size')->nullable()->index();

				$table->longtext('p_micro')->nullable()->fullText();
				$table->longtext('p_small')->nullable()->fullText();
				$table->longtext('p_medium')->nullable()->fullText();
				$table->longtext('p_normal')->nullable()->fullText();
				$table->longtext('p_big')->nullable()->fullText();
				$table->longtext('p_original')->nullable()->fullText();

				$table->varchar('p_hash')->notNull()->unique();
				$table->varchar('p_mime')->nullable()->index();
				$table->varchar('p_status')->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('p_');
			});
			return $this;
		}











	}