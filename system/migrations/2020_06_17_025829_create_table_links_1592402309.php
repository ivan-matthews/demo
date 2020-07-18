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
				$table->bigint('id')->unsigned()->autoIncrement()->primary();
				$table->bigint('menu_id')->unsigned()->nullable();
				$table->bigint('parent_id')->unsigned()->nullable();
				$table->longtext('link_array')->nullable();
				$table->varchar('name')->nullable();
				$table->varchar('title')->nullable();
				$table->varchar('value')->notNull()->defaults('home.default_link_value');
				$table->varchar('css_class')->notNull()->defaults('menu-link');
				$table->varchar('image')->nullable();
				$table->varchar('css_class_image')->nullable();
				$table->varchar('icon')->notNull()->defaults('fa fa-anchor');
				$table->varchar('css_class_icon')->nullable();
				$table->int('status')->notNull()->defaults(Kernel::STATUS_ACTIVE);
				$table->int('ordering')->notNull()->defaults(1);
				$table->longtext('options')->nullable();
				$table->add_timestamps();
			});
			return $this;
		}











	}