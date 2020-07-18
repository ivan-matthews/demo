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
				$table->bigint('wa_id')->unsigned()->autoIncrement()->primary();

				$table->bigint('wa_widget_id')->unsigned()->nullable();
				$table->varchar('wa_name')->notNull()->unique();
				$table->varchar('wa_title')->nullable();
				$table->varchar('wa_css_class')->nullable();
				$table->varchar('wa_css_class_title')->nullable();
				$table->varchar('wa_css_class_body')->nullable();
				$table->boolean('wa_show_title')->defaults(true);
				$table->boolean('wa_unite_prev')->defaults('0');	// объединить с предыдущим ?
				$table->varchar('wa_status')->nullable()->defaults(Kernel::STATUS_ACTIVE);
				$table->varchar('wa_position')->nullable();
				$table->int('wa_ordering')->notNull()->defaults(1);
				$table->varchar('wa_template')->nullable();
				$table->longtext('wa_groups_enabled')->nullable();
				$table->longtext('wa_groups_disabled')->nullable();
				$table->longtext('wa_pages_enabled')->nullable();
				$table->longtext('wa_pages_disabled')->nullable();

				$table->add_timestamps('wa_');
			});
			return $this;
		}











	}