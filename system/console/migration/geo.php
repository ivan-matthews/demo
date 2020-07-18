<?php

	#CMD: migration geo
	#DSC: cli.make_geo_data
	#EXM: migration geo

	namespace System\Console\Migration;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	/**
	 *	fx_die(
	 *		(new \System\Console\Migration\Geo())
	 *			->setProps()
	 *				->parseCSVs()
	 *					->getResult()
	 *	);
	 */

	class Geo extends Console{

		protected $result_array = array();

		protected $zip_path = 'system/cache/trash/geo/zip';
		protected $txt_path = 'system/cache/trash/geo/txt';
		protected $links;
		protected $keys = array(
			'id',
			'name',
			'ascii_name',
			'alternate_names',
			'latitude',
			'longitude',
			'feature_class',
			'feature_code',
			'country_code',
			'country_code_alt',
			'admin1_code',
			'admin2_code',
			'admin3_code',
			'admin4_code',
			'population',
			'elevation',
			'digital_model',
			'timezone',
			'mod_date',
		);

		public function execute(){
			$this->setProps();
			$this->downloadZips();
			$this->saveZips();
			$this->extractZips();
			$this->parseCSVs();
			return $this->result_array;
		}

		public function setProps(){
			$this->zip_path = fx_path($this->zip_path);
			$this->txt_path = fx_path($this->txt_path);
			fx_make_dir($this->zip_path);
			fx_make_dir($this->txt_path);
			return $this;
		}

		public function downloadZips(){
			$str = file_get_contents('http://download.geonames.org/export/dump');
			preg_match_all("#\<a(.*?)\>([A-Z]{2}\.zip)\<\/a\>#",$str,$this->links);
			return $this;
		}

		public function saveZips(){
			foreach($this->links[2] as $link){
				file_put_contents(
					"{$this->zip_path}/{$link}",
					file_get_contents("http://download.geonames.org/export/dump/{$link}")
				);
			}
			return $this;
		}

		public function extractZips(){
			$files = array();
			foreach(scandir($this->zip_path) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$files[] = pathinfo($file,PATHINFO_FILENAME);

				$zip = new \ZipArchive;
				$res = $zip->open("{$this->zip_path}/{$file}");
				if ($res === TRUE) {
					$zip->extractTo($this->txt_path);
					$zip->close();
				}
			}
			unlink("{$this->txt_path}/readme.txt");
			return $this;
		}

		public function parseCSVs(){
			foreach(scandir($this->txt_path) as $file){	/* test */
				if($file == '.' || $file == '..'		/*|| $file != 'UA.txt'*/){ continue; }
				$csv_array = file("{$this->txt_path}/{$file}");
//				$str_count = 0;							// удалить затем
				foreach($csv_array as $value){
//					if($str_count > 10){ break; }		// удалить затем
					$this->result_array[] = array_combine($this->keys,str_getcsv($value,'		'));
//					$str_count++;						// удалить затем
				}
			}
			return $this;
		}

		public function getResult(){
			return $this->result_array;
		}















	}