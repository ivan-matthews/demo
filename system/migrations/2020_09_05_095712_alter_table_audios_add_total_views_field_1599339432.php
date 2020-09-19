<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
//	use Core\Classes\Database\Alter;
	use Core\Classes\Database\Interfaces\Alter\Alter;

	class AlterTableAudiosAddTotalViewsField202009050957121599339432{

		public function firstStep(){

			return $this;
		}

		public function secondStep(){
			Database::alterTable('audios',function(Alter $table){
				$table->field('au_total_views')->addColumn()->bigint()->unsigned()->notNull()->defaults(0);
			});
			return $this;
		}











	}