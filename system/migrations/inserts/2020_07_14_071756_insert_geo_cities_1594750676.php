<?php

	// иц ворк!

	namespace System\Migrations\Inserts;

	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Kernel;
	use Core\Classes\Database\Database;
	use Core\Classes\Response\Response;
	use Core\Classes\Config;
	use IvanMatthews\GeoPack\Geo;

	/**
	 * select * from geo_regions
	 * 	where gr_region_id not in (
	 * 		select gc_region_id
	 * 			from geo_cities
	 * 				where gc_region_id=gr_region_id
	 * 	)
	 *
	 * Class InsertGeoCities202007140717561594750676
	 * @package System\Migrations\Inserts
	 */
	class InsertGeoCities202007140717561594750676{

		/** @var Config */
		public $config;

		/** @var Geo */
		protected $geo;

		/** @var boolean */
		public $debug;

		/** @var integer */
		private $total_cities;

		private $memory_limit  = 256 * 1024 * 1024;			// 256M

		public function __construct(){
			$this->config = Config::getInstance();
			$this->debug = $this->config->core['debug_enabled'];

			$this->checkGeoClass();
			$this->geo = new Geo();
			$this->getOffset();
		}
		
		private function checkGeoClass(){
			if(!class_exists("\\IvanMatthews\\GeoPack\\Geo")){
				$class_file = fx_path("vendor/ivan-matthews/geo-package/src/Geo.php");
				include $class_file;
			}
			return $this;
		}

		public function firstStep(){
			$this->debug(false);

			$this->getMemoryLimit();

			$this->geo->call($this->geo->getCitiesFiles(),function($file){

				if($this->geo->getFileName() < $this->total_cities){ return false; }

				$data = fx_import_file($file,Kernel::IMPORT_INCLUDE);

				$this->reconnectByMemoryLimit()
					->lastHope();

				$insert = Database::insert('geo_cities');
				foreach($data as $item){
					$region = md5($item['gc_region']);

					$insert = $insert->value('gc_city_id',$item['gc_city_id']);
					$insert = $insert->value('gc_country_id',$item['gc_country_id']);
					$insert = $insert->value('gc_area',$item['gc_area']);
					$insert = $insert->value('gc_title_ru',$item['gc_title_ru']);
					$insert = $insert->value('gc_title_en',$item['gc_title_en']);
					$insert = $insert->query('gc_region_id',
						"(select gr_region_id from geo_regions where (gr_title_ru=%{$region}% or gr_title_en=%{$region}%) and gr_country_id='{$item['gc_country_id']}' limit 1)"
					);
					$insert = $insert->data("%{$region}%",$item['gc_region']);
					$insert = $insert->updateQuery('gc_title_ru','gc_title_ru');
				}
				$insert->get()->id();

				$this->printFile($file);

				return true;
			});

			$this->debug($this->debug);

			return $this;
		}

		private function printFile($file){
			Paint::exec(function(Types $types)use($file){
				$types->string("File: ")->print();
				$types->string($file)->color('yellow')->print();
				$types->eol();
			});
			return $this;
		}

		private function debug($debug_status){
			$this->config->set($debug_status,'core','debug_enabled');
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