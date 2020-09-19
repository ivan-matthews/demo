<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use IvanMatthews\GeoPack\Geo;

	class InsertGeoRegions202007140717511594750671{

		/** @var Geo */
		protected $geo;

		public function firstStep(){
			$this->geo = new Geo();

			$this->geo->call($this->geo->getRegionsFiles(),function($file){
				$data = fx_import_file($file,Kernel::IMPORT_INCLUDE);
				$insert = Database::insert('geo_regions');
				foreach($data as $item){
					$insert->value('gr_region_id',$item['gr_region_id']);
					$insert->value('gr_country_id',$item['gr_country_id']);
					$insert->value('gr_title_ru',$item['gr_title_ru']);
					$insert = $insert->value('gr_title_en',$item['gr_title_en']);
				}
				$insert->get()->id();
			});
			return $this;
		}












	}