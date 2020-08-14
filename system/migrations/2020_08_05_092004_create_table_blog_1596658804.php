<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableBlog202008050920041596658804{

		public function firstStep(){
			Database::getInstance()
				->dropTable('blog');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('blog',function(Create $table){
				$table->bigint('b_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('b_user_id')->nullable()->index();
				$table->bigint('b_total_views')->notNull()->defaults(0)->index();
				$table->bigint('b_total_comments')->notNull()->defaults(0)->index();

				$table->bigint('b_image_preview_id')->nullable()->index();
				$table->varchar('b_title',191)->nullable()->index();
				$table->varchar('b_slug',191)->nullable()->unique();

				$table->tinyint('b_status',1)->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->tinyint('b_comments_enabled',1)->notNull()->defaults(1)->index();
				$table->tinyint('b_public',1)->notNull()->defaults(1)->index();

				$table->bigint('b_category_id')->notNull()->defaults(1)->index();

				$table->longtext('b_content')->nullable()->fullText();

				$table->add_timestamps('b_');
			});
			return $this;
		}











	}