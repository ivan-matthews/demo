<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTablePages202009220803471600801427{

		public function firstStep(){
			Database::getInstance()
				->dropTable('pages');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('pages',function(Create $table){
				$table->bigint('pg_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('pg_user_id')->nullable()->index();
				$table->bigint('pg_total_views')->notNull()->defaults(0)->index();
				$table->bigint('pg_total_comments')->notNull()->defaults(0)->index();

				$table->bigint('pg_image_preview_id')->nullable()->index();
				$table->varchar('pg_title',191)->nullable()->index();
				$table->varchar('pg_slug',191)->nullable()->unique();

				$table->tinyint('pg_status',1)->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->tinyint('pg_comments_enabled',1)->notNull()->defaults(1)->index();
				$table->tinyint('pg_public',1)->notNull()->defaults(1)->index();

				$table->bigint('pg_category_id')->notNull()->defaults(1)->index();

				$table->longtext('pg_content')->nullable()->fullText();
				$table->text('pg_attachments_ids')->nullable()->fullText();

				$table->add_timestamps('pg_');
			});
			return $this;
		}











	}