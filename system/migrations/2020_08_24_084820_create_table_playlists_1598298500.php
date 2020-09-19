<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTablePlayLists202008240848201598298500{

		public function firstStep(){
			Database::getInstance()
				->dropTable('audio_lists');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('audio_lists',function(Create $table){
				$table->bigint('al_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('al_user_id')->unsigned()->notNull()->index();
				$table->bigint('al_preview_image_id')->unsigned()->notNull()->index();
				$table->varchar('al_title')->nullable()->index();
				$table->varchar('al_description')->nullable()->index();
				$table->tinyint('al_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('al_');
			});
			return $this;
		}











	}