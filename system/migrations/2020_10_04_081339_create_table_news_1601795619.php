<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableNews202010040813391601795619{

		public function firstStep(){
			Database::getInstance()
				->dropTable('news');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('news',function(Create $table){
				$table->bigint('nw_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('nw_user_id')->nullable()->index();
				$table->bigint('nw_total_views')->notNull()->defaults(0)->index();
				$table->bigint('nw_total_comments')->notNull()->defaults(0)->index();

				$table->bigint('nw_image_preview_id')->nullable()->index();
				$table->varchar('nw_title',191)->nullable()->index();
				$table->varchar('nw_slug',191)->nullable()->unique();

				$table->varchar('nw_hash',191)->nullable()->unique();
				$table->tinyint('nw_show_image_in_item')->notNull()->defaults(0)->index();

				$table->tinyint('nw_status',1)->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->tinyint('nw_comments_enabled',1)->notNull()->defaults(1)->index();
				$table->tinyint('nw_public',1)->notNull()->defaults(1)->index();

				$table->bigint('nw_category_id')->notNull()->defaults(1)->index();

				$table->longtext('nw_content')->nullable()->fullText();
				$table->text('nw_attachments_ids')->nullable()->fullText();

				$table->add_timestamps('nw_');
			});
			return $this;
		}











	}
