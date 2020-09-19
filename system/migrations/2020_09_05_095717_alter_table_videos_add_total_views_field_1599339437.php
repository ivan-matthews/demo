<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
//	use Core\Classes\Database\Alter;
	use Core\Classes\Database\Interfaces\Alter\Alter;

	class AlterTableVideosAddTotalViewsField202009050957171599339437{

		public function firstStep(){

			return $this;
		}

		public function secondStep(){
			Database::alterTable('videos',function(Alter $table){
				$table->field('v_total_views')->addColumn()->bigint()->unsigned()->notNull()->defaults(0);
			});
			return $this;
		}











	}