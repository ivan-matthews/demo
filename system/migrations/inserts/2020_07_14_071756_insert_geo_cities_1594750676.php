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
		private $insert_files = array();
		private $file_path = 'system/migrations/inserts/geo/cities';
		private $total_cities;

		public function firstStep(){
			$this->getMemoryLimit();
			$this->getFiles();
			$this->getOffset();

			foreach($this->insert_files as $file){
				if(is_dir("{$this->file_path}/{$file}")){ continue; }
				$number = substr($file,0,-4);
				if($number < $this->total_cities){ continue; }

				$path = "{$this->file_path}/{$file}";
				$data = fx_import_file($path,Kernel::IMPORT_INCLUDE);

				$this->reconnectByMemoryLimit()
					->lastHope();

				foreach($data as $item){

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

				Paint::exec(function(Types $types)use($file){
					$types->string("File: ")->print();
					$types->string($file)->color('yellow')->print();
					$types->eol();
				});

				unset($insert,$path,$data,$item);
			}
			return $this;
		}

		private function getMemoryLimit(){
			$memory_limit = ini_get('memory_limit');

			if($memory_limit > 1){
				$this->memory_limit = $this->prepareMemorySuffix($memory_limit);
			}

			Paint::exec(function(Types $types){
				$types->string("Memory limit: ")->print();
				$types->string(number_format($this->memory_limit))->fon('green')->print();
				$types->string(" bytes")->print();
				$types->eol();
			});
			return $this;
		}

		private function getFiles(){
			$this->file_path = fx_path($this->file_path);

			$this->insert_files = scandir($this->file_path);
			unset($this->insert_files[0],$this->insert_files[1]);
			sort($this->insert_files,SORT_NATURAL);

			return $this;
		}

		private function getOffset(){
			$total_cities = Database::select('count(gc_country_id) as total')
				->from('geo_cities')
				->get()->itemAsArray();
			$total_cities = $total_cities['total']/1000;
			$total_cities = (int)$total_cities;
			$this->total_cities = $total_cities*1000;
			return $this;
		}

		private function reconnectByMemoryLimit(){
			if(memory_get_usage() > $this->memory_limit){
				Response::getInstance()
					->resetDebug()
					->resetErrors();
				Paint::exec(function(Types $types){
					$types->string('debug reset')->fon('green')->print();
					$types->eol();
				});
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

		private function prepareMemorySuffix($memory){
			$letter = strtolower(substr($memory,-1));
			$mem_size = substr($memory,0,-1);
			switch($letter){
				case fx_equal($letter,'b'):
					return $mem_size;
					break;
				case fx_equal($letter,'k'):
					return $mem_size * 1024;
					break;
				case fx_equal($letter,'m'):
					return $mem_size * 1024 * 1024;
					break;
				case fx_equal($letter,'g'):
					return $mem_size * 1024 * 1024 * 1024;
					break;
				case fx_equal($letter,'t'):
					return $mem_size * 1024 * 1024 * 1024 * 1024;
					break;
				case fx_equal($letter,'p'):
					return $mem_size * 1024 * 1024 * 1024 * 1024 * 1024;
					break;
				default:
					return $mem_size;
			}
		}







	}