<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
//	use Core\Classes\Database\Alter;
	use Core\Classes\Database\Interfaces\Alter\Alter;

	class AlterTablePhotosAddTotalViewsField202009050957061599339426{

		public function firstStep(){

			return $this;
		}

		public function secondStep(){
			Database::alterTable('photos',function(Alter $table){
				$table->field('p_total_views')->addColumn()->bigint()->unsigned()->notNull()->defaults(0);
			});
			return $this;
		}











	}