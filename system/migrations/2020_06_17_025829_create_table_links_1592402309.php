<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableLinks202006170258291592402309{

		public function firstStep(){
			Database::getInstance()
				->dropTable('links');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('links',function(Create $table){
				$table->bigint('l_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('l_menu_id')->unsigned()->nullable()->index();
				$table->bigint('l_parent_id')->unsigned()->nullable()->index();
				$table->longtext('l_link_array')->nullable()->fullText();
				$table->varchar('l_name')->nullable()->index();
				$table->varchar('l_title')->nullable()->index();
				$table->varchar('l_value')->notNull()->defaults('home.default_link_value')->index();
				$table->varchar('l_css_class')->notNull()->defaults('menu-link')->index();
				$table->varchar('l_image')->nullable()->index();
				$table->varchar('l_css_class_image')->nullable()->index();
				$table->varchar('l_icon')->notNull()->defaults('fa fa-anchor')->index();
				$table->varchar('l_css_class_icon')->nullable()->index();
				$table->int('l_status')->notNull()->defaults(Kernel::STATUS_ACTIVE)->index();
				$table->int('l_ordering')->notNull()->defaults(1)->index();
				$table->longtext('l_options')->nullable()->fullText();
				$table->add_timestamps('l_');
			});
			return $this;
		}











	}