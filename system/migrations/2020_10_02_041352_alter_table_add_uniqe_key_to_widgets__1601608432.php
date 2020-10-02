<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
//	use Core\Classes\Database\Alter;
	use Core\Classes\Database\Interfaces\Alter\Alter;

	class AlterTableAddUniqeKeyToWidgets202010020413521601608432{

		public function firstStep(){

			return $this;
		}

		public function secondStep(){
			Database::alterTable('widgets',function(Alter $table){
				$table->field('w_class')->changeColumn('w_class')->varchar(191)->nullable()->addUnique();
			});
			return $this;
		}











	}