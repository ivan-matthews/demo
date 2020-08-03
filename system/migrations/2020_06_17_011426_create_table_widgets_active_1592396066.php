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

				$table->bigint('wa_widget_id')->unsigned()->nullable()->index();
				$table->varchar('wa_name')->notNull()->unique();
				$table->varchar('wa_title')->nullable()->index();
				$table->varchar('wa_css_class')->nullable()->index();
				$table->varchar('wa_css_class_title')->nullable()->index();
				$table->varchar('wa_css_class_body')->nullable()->index();
				$table->boolean('wa_show_title')->defaults(true)->index();
				$table->boolean('wa_unite_prev')->defaults('0')->index();	// объединить с предыдущим ?
				$table->varchar('wa_status')->nullable()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->varchar('wa_position')->nullable()->index();
				$table->int('wa_ordering')->notNull()->defaults(1)->index();
				$table->varchar('wa_template')->nullable()->index();
				$table->longtext('wa_groups_enabled')->nullable()->fullText();
				$table->longtext('wa_groups_disabled')->nullable()->fullText();
				$table->longtext('wa_pages_enabled')->nullable()->fullText();
				$table->longtext('wa_pages_disabled')->nullable()->fullText();

				$table->add_timestamps('wa_');
			});
			return $this;
		}











	}