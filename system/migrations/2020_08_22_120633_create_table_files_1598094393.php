<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableFiles202008221206331598094393{

		public function firstStep(){
			Database::getInstance()
				->dropTable('files');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('files',function(Create $table){
				$table->bigint('f_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('f_user_id')->nullable()->index();
				$table->varchar('f_folder_id')->notNull()->defaults(1)->index();
				$table->longtext('f_description')->nullable()->fullText();
				$table->bigint('f_total_comments')->notNull()->defaults(0)->index();
				$table->varchar('f_name')->nullable()->index();
				$table->varchar('f_size')->nullable()->index();

				$table->longtext('f_path')->nullable()->fullText();

				$table->varchar('f_hash')->notNull()->unique();
				$table->varchar('f_mime')->nullable()->index();
				$table->varchar('f_status')->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('f_');
			});
			return $this;
		}











	}