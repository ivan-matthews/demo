<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertGeoCountries202007140717431594750663{

		public function firstStep(){
			$files_path = fx_path('system/migrations/inserts/geo/countries');
			foreach(scandir($files_path) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$path = "{$files_path}/{$file}";
				$data = fx_import_file($path,Kernel::IMPORT_INCLUDE);
				$insert = Database::insert('geo_countries');
				foreach($data as $item){
					$insert->value('g_country_id',$item['g_country_id']);
					$insert->value('g_total_regions',$item['g_total_regions']);
					$insert->value('g_total_cities',$item['g_total_cities']);
					$insert->value('g_title_ru',$item['g_title_ru']);
					$insert = $insert->value('g_title_en',$item['g_title_en']);
				}
				$insert->get()->id();
				unset($insert,$path,$data,$item);
			}
			return $this;
		}











	}