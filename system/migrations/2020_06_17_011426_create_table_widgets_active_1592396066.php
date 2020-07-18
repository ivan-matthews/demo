<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableWidgetsActive202006170114261592396066{

		public function firstStep(){
			Database::getInstance()
				->dropTable('widgets_active');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('widgets_active',function(Create $table){
				$table->bigint('id')->unsigned()->autoIncrement()->primary();

				$table->bigint('widget_id')->unsigned()->nullable();
				$table->varchar('name')->notNull()->unique();
				$table->varchar('title')->nullable();
				$table->varchar('css_class')->nullable();
				$table->varchar('css_class_title')->nullable();
				$table->varchar('css_class_body')->nullable();
				$table->boolean('show_title')->defaults(true);
				$table->boolean('unite_prev')->defaults('0');	// объединить с предыдущим ?
				$table->varchar('status')->nullable()->defaults(Kernel::STATUS_ACTIVE);
				$table->varchar('position')->nullable();
				$table->int('ordering')->notNull()->defaults(1);
				$table->varchar('template')->nullable();
				$table->longtext('groups_enabled')->nullable();
				$table->longtext('groups_disabled')->nullable();
				$table->longtext('pages_enabled')->nullable();
				$table->longtext('pages_disabled')->nullable();

				$table->add_timestamps();
			});
			return $this;
		}











	}