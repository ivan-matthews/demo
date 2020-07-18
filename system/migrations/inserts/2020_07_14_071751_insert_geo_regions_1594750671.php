<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertGeoRegions202007140717511594750671{

		public function firstStep(){
			$files_path = fx_path('system/migrations/inserts/geo/regions');
			foreach(scandir($files_path) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$path = "{$files_path}/{$file}";
				$data = fx_import_file($path,Kernel::IMPORT_INCLUDE);
				$insert = Database::insert('geo_regions');
				foreach($data as $item){
					$insert->value('gr_region_id',$item['gr_region_id']);
					$insert->value('gr_country_id',$item['gr_country_id']);
					$insert->value('gr_title_ru',$item['gr_title_ru']);
					$insert = $insert->value('gr_title_en',$item['gr_title_en']);
				}
				$insert->get()->id();
				unset($insert,$path,$data,$item);
			}
			return $this;
		}











	}