<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableFolders202008240848121598298492{

		public function firstStep(){
			Database::getInstance()
				->dropTable('file_folders');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('file_folders',function(Create $table){
				$table->bigint('ff_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('ff_user_id')->unsigned()->notNull()->index();
				$table->bigint('ff_preview_image_id')->unsigned()->notNull()->index();
				$table->varchar('ff_title')->nullable()->index();
				$table->varchar('ff_description')->nullable()->index();
				$table->tinyint('ff_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('ff_');
			});
			return $this;
		}











	}