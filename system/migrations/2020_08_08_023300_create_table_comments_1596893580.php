<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableComments202008080233001596893580{

		public function firstStep(){
			Database::getInstance()
				->dropTable('comments');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('comments',function(Create $table){
				$table->bigint('c_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('c_author_id')->comment('комментатор')->nullable()->index();
				$table->bigint('c_receiver_id')->comment('получатель')->nullable()->index();
				$table->bigint('c_parent_id')->comment('ID родителя')->nullable()->index();
				$table->bigint('c_parent_count')->comment('количество ответов на этот коммент')->nullable()->index();

				$table->varchar('c_controller')->nullable()->index();
				$table->varchar('c_action')->nullable()->index();
				$table->varchar('c_item_id')->nullable()->index();

				$table->tinyint('с_status',1)->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->tinyint('с_public',1)->notNull()->defaults(1)->index();

				$table->longtext('c_content')->nullable()->fullText();

				$table->add_timestamps('c_');
			});
			return $this;
		}











	}