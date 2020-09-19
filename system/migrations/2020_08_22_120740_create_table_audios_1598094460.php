<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableAudios202008221207401598094460{

		public function firstStep(){
			Database::getInstance()
				->dropTable('audios');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('audios',function(Create $table){
				$table->bigint('au_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('au_user_id')->nullable()->index();
				$table->varchar('au_playlist_id')->notNull()->defaults(1)->index();
				$table->longtext('au_description')->nullable()->fullText();
				$table->bigint('au_total_comments')->notNull()->defaults(0)->index();
				$table->bigint('au_total_views')->unsigned()->notNull()->defaults(0);
				$table->varchar('au_name')->nullable()->index();
				$table->varchar('au_size')->nullable()->index();

				$table->longtext('au_path')->nullable()->fullText();

				$table->varchar('au_hash')->notNull()->unique();
				$table->varchar('au_mime')->nullable()->index();
				$table->varchar('au_status')->defaults(Kernel::STATUS_ACTIVE)->index();

				$table->add_timestamps('au_');
			});
			return $this;
		}











	}