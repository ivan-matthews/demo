<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableVideoLists202008240848271598298507{

		public function firstStep(){
			Database::getInstance()
				->dropTable('video_lists');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('video_lists',function(Create $table){
				$table->bigint('vl_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('vl_user_id')->unsigned()->notNull()->index();
				$table->bigint('vl_preview_image_id')->unsigned()->notNull()->index();
				$table->varchar('vl_title')->nullable()->index();
				$table->varchar('vl_description')->nullable()->index();
				$table->tinyint('vl_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('vl_');
			});
			return $this;
		}











	}