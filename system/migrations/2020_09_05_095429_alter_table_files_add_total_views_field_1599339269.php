<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
//	use Core\Classes\Database\Alter;
	use Core\Classes\Database\Interfaces\Alter\Alter;

	class AlterTableFilesAddTotalViewsField202009050954291599339269{

		public function firstStep(){
			Database::alterTable('files',function(Alter $table){
				$table->field('f_total_views')->addColumn()->bigint()->unsigned()->notNull()->defaults(0);
			});
			return $this;
		}











	}