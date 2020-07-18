<?php

	namespace System\Migrations;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Create\Create;

	class CreateTableGeoCountries202007140640331594748433{

		public function firstStep(){
			Database::getInstance()
				->dropTable('geo_countries');
			return $this;
		}

		public function secondStep(){
			Database::makeTable('geo_countries',function(Create $table){
				$table->bigint('g_id')->unsigned()->autoIncrement()->primary();
				$table->bigint('g_country_id')->unsigned()->nullable()->unique();
				$table->bigint('g_total_regions')->unsigned()->nullable()->index();
				$table->bigint('g_total_cities')->unsigned()->nullable()->index();
				$table->varchar('g_title_ru')->nullable()->index();
				$table->varchar('g_title_en')->nullable()->index();
			});
			return $this;
		}











	}