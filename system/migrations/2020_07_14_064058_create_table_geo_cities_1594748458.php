<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableGeoCities202007140640581594748458{

		public function firstStep(){
			Database::getInstance()
				->dropTable('geo_cities');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('geo_cities',function(Create $table){
				$table->bigint('gc_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('gc_city_id')->unsigned()->nullable()->unique();
				$table->bigint('gc_region_id')->unsigned()->nullable()->index();
				$table->bigint('gc_country_id')->unsigned()->nullable()->index();
//				$table->varchar('gc_region')->nullable()->index();
				$table->varchar('gc_area')->nullable()->index();
//				$table->varchar('gc_title')->nullable()->index();
				$table->varchar('gc_title_ru')->nullable()->index();
				$table->varchar('gc_title_en')->nullable()->index();
			});
			return $this;
		}











	}