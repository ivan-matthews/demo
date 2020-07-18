<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableGeoRegions202007140640461594748446{

		public function firstStep(){
			Database::getInstance()
				->dropTable('geo_regions');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('geo_regions',function(Create $table){
				$table->bigint('gr_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('gr_region_id')->unsigned()->nullable()->unique();
				$table->bigint('gr_country_id')->unsigned()->nullable()->index();
//				$table->varchar('gr_title')->nullable()->index();
				$table->varchar('gr_title_ru')->nullable()->index();
				$table->varchar('gr_title_en')->nullable()->index();
			});
			return $this;
		}











	}