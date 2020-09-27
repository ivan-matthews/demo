<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use IvanMatthews\GeoPack\Geo;

	class InsertGeoCountries202007140717431594750663{

		/** @var Geo */
		protected $geo;
		public function firstStep(){
			$this->checkGeoClass();
			$this->geo = new Geo();

			$this->geo->call($this->geo->getCountriesFiles(),function($file){
				$data = fx_import_file($file,Kernel::IMPORT_INCLUDE);
				$insert = Database::insert('geo_countries');
				foreach($data as $item){
					$insert->value('g_country_id',$item['g_country_id']);
					$insert->value('g_total_regions',$item['g_total_regions']);
					$insert->value('g_total_cities',$item['g_total_cities']);
					$insert->value('g_title_ru',$item['g_title_ru']);
					$insert = $insert->value('g_title_en',$item['g_title_en']);
				}
				$insert->get()->id();
			});
			return $this;
		}

		private function checkGeoClass(){
			if(!class_exists(Geo::class)){
				$class_file = fx_path("vendor/ivan-matthews/geo-package/src/Geo.php");
				include $class_file;
			}
			return $this;
		}











	}