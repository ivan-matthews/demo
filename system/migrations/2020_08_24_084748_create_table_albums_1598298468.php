<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableAlbums202008240847481598298468{

		public function firstStep(){
			Database::getInstance()
				->dropTable('photo_albums');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('photo_albums',function(Create $table){
				$table->bigint('pa_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('pa_user_id')->unsigned()->notNull()->index();
				$table->bigint('pa_preview_image_id')->unsigned()->notNull()->index();
				$table->varchar('pa_title')->nullable()->index();
				$table->varchar('pa_description')->nullable()->index();
				$table->tinyint('pa_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('pa_');
			});
			return $this;
		}











	}