<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;
	use Core\Classes\Kernel;

	class CreateTableMenu202006170258261592402306{

		public function firstStep(){
			Database::getInstance()
				->dropTable('menu');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('menu',function(Create $table){
				$table->bigint('m_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('m_widget_id')->unsigned()->nullable();
				$table->varchar('m_name')->notNull()->unique();
				$table->varchar('m_title')->nullable();
				$table->int('m_status')->notNull()->defaults(Kernel::STATUS_ACTIVE);
				$table->add_timestamps('m_');
			});
			return $this;
		}











	}