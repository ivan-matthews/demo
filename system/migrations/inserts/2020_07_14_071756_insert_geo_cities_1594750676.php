<?php

	// иц воркс!

	namespace System\Migrations\Inserts;

	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Kernel;
	use Core\Classes\Database\Database;
	use Core\Classes\Response\Response;

	class InsertGeoCities202007140717561594750676{

		private $memory_limit  = 256 * 1024 * 1024;			// 256M

		public function firstStep(){
			$files_path = fx_path('system/migrations/inserts/geo/cities');

			$all_files = scandir($files_path);
			unset($all_files[0],$all_files[1]);
			sort($all_files,SORT_NATURAL);

			$total_cities = $this->getOffset();
			foreach($all_files as $file){
				if(is_dir("{$files_path}/{$file}")){ continue; }
				$number = substr($file,0,-4);
				if($number < $total_cities){ continue; }

				$path = "{$files_path}/{$file}";
				$data = fx_import_file($path,Kernel::IMPORT_INCLUDE);

				foreach($data as $item){

					$this->reconnectByMemoryLimit()
						->lastHope();

					$insert = Database::insert('geo_cities');
					$insert = $insert->value('gc_city_id',$item['gc_city_id']);
					$insert = $insert->value('gc_country_id',$item['gc_country_id']);
					$insert = $insert->value('gc_area',$item['gc_area']);
					$insert = $insert->value('gc_title_ru',$item['gc_title_ru']);
					$insert = $insert->value('gc_title_en',$item['gc_title_en']);

					if(!$item['gc_region']){
						$insert = $insert->value('gc_region_id',null);
					}else{
						$insert = $insert->query('gc_region_id',
							"(select gr_region_id from geo_regions where gr_title_ru=%region_id% or gr_title_en=%region_id% limit 1)"
						);
						$insert = $insert->data('%region_id%',$item['gc_region']);
					}
					$insert = $insert->update('gc_title_ru',$item['gc_title_ru']);
					$insert->get()->id();
				}

				print "File: {$file}" . PHP_EOL;
				unset($insert,$path,$data,$item);
			}
			return $this;
		}

		private function getOffset(){
			$total_cities = Database::select('count(gc_country_id) as total')
				->from('geo_cities')
				->get()->itemAsArray();
			$total_cities = $total_cities['total']/1000;
			$total_cities = (int)$total_cities;
			$total_cities = $total_cities*1000;
			return $total_cities;
		}

		private function reconnectByMemoryLimit(){
			if(memory_get_usage() > $this->memory_limit){
				Response::getInstance()
					->resetDebug()
					->resetErrors();
			}
			return $this;
		}

		private function lastHope(){
			if(memory_get_usage() > $this->memory_limit+10240000){
				Paint::exec(function(Types $types){
					$types->eol(2);
					$types->string("ERROR: memory limit - " . $this->memory_limit . " ...")->fon('red')->print();
					$types->eol(2);
				});
				die();
			}
			return $this;
		}








	}