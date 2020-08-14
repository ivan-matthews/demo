<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableCategories202008111031011597181461{

		public function firstStep(){
			Database::getInstance()
				->dropTable('categories');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('categories',function(Create $table){
				$table->bigint('ct_id')->unsigned()->autoIncrement()->primary();

				$table->varchar('ct_name')->notNull()->unique();
				$table->varchar('ct_controller')->notNull()->index();
				$table->varchar('ct_title')->nullable()->index();
				$table->varchar('ct_icon')->notNull()->defaults('fa fa-list')->index();

				$table->text('ct_description')->nullable()->fullText();
				$table->bigint('ct_order')->nullable()->index();

				$table->tinyint('ct_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);

				$table->add_timestamps('ct_');
			});
			return $this;
		}











	}