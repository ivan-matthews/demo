<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableVideos202008221208171598094497{

		public function firstStep(){
			Database::getInstance()
				->dropTable('videos');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('videos',function(Create $table){
				$table->bigint('v_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('v_user_id')->nullable()->index();
				$table->varchar('v_videolist_id')->notNull()->defaults(1)->index();
				$table->bigint('v_total_comments')->notNull()->defaults(0)->index();
				$table->varchar('v_name')->nullable()->index();
				$table->varchar('v_size')->nullable()->index();

				$table->longtext('v_path')->nullable()->fullText();

				$table->varchar('v_hash')->notNull()->unique();
				$table->varchar('v_mime')->nullable()->index();
				$table->varchar('v_status')->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('v_');
			});
			return $this;
		}











	}