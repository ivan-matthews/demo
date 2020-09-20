<?php

	namespace Core\Controllers\Home\Cron;

	use Core\Classes\Database\Database;
	use Core\Classes\Config;

	class Test{

		private $country_id = 1;
		private $params;
		private $config;
		private $database;
		private static $count = 0;

		public function  __construct(){
			$this->config = Config::getInstance();
			$this->database = Database::getInstance();
//		$this->database->useDb('mc');
		}

		public function destruct(){
//			$this->database->useDb('new_database');
			return $this;
		}

		/**
		 * @param array $params 'cron_task' item array from DB
		 * @return string | boolean
		 */

		public function execute($params){
			$this->params = $params;

//			$this->addRegion();
//			$this->destruct();

			return $this->country_id;
		}

		/**
		 * Обновить общее количество гоодов в таблице стран
		 *
		 * @return $this|bool
		 */
		public function updateGeoCountriesTotalCity(){
			$null_country = Database::select('g_country_id')
				->from('geo_countries')
				->where("isnull(g_total_cities)")
				->limit(1)
				->get()
				->itemAsArray();
			if(!$null_country){
				return false;
			}
			$query = array(
				'country_id'	=> $null_country['g_country_id'],
				'need_all'		=> '1',
				'lang'			=> 'ru',
				'count'			=> '1',
			);
			$cities_response = $this->downloadDataByURL('getCities',$query);

			if(isset($cities_response['response']['count'])){
				Database::update('geo_countries')
					->field('g_total_cities',$cities_response['response']['count'])
					->where("`g_country_id`='{$null_country['g_country_id']}'")
					->get()
					->rows();
			}
			return $this;
		}

		/**
		 * Добавить регионы по ID страны
		 *
		 * @return $this|Test
		 */
		public function addRegion(){
			$this->country_id = $this->params['ct_result'] > $this->country_id ?
				$this->params['ct_result'] : $this->country_id;

			$null_country = Database::select('g_country_id')
				->from('geo_countries')
				->where("`id`={$this->country_id}")
				->get()
				->itemAsArray();

			if(!$null_country){
				return $this;
			}

			$query = array(
				'country_id'	=> $null_country['g_country_id'],
				'need_all'		=> '1',
				'lang'			=> 'ru',
				'count'			=> '1000',
			);
			$russian_regions = $this->downloadDataByURL('getRegions',$query);
			$query['lang'] = 'en';
			$english_regions = $this->downloadDataByURL('getRegions',$query);

			if($russian_regions){
				foreach($russian_regions['response']['items'] as $key=>$val){
					Database::insert('geo_regions')
						->value('gr_country_id',$null_country['g_country_id'])
						->value('gr_region_id',$val['id'])
						->value('gr_title',$val['title'])
						->value('gr_title_ru',$val['title'])
						->value('gr_title_en',$english_regions['response']['items'][$key]['title'])
						->update('gr_title',$val['title'])
						->get()
						->id();
				}
			}

			$this->country_id++;

			if(self::$count > 50){
				return $this;
			}

			self::$count++;

			return $this->addRegion();
		}

		/**
		 * Обновить общее количество регионов в таблице стран
		 *
		 * @return $this|bool
		 */
		public function updateGeoCountriesTotalRegion(){
			$null_country = Database::select('g_country_id')
				->from('geo_countries')
				->where("isnull(g_total_regions)")
				->limit(1)
				->get()
				->itemAsArray();
			if(!$null_country){
				return false;
			}
			$query = array(
				'country_id'	=> $null_country['g_country_id'],
				'lang'			=> 'ru',
				'count'			=> '1',
			);
			$regions_response = $this->downloadDataByURL('getRegions',$query);

			if(isset($regions_response['response']['count'])){
				Database::update('geo_countries')
					->field('g_total_regions',$regions_response['response']['count'])
					->where("`g_country_id`='{$null_country['g_country_id']}'")
					->get()
					->rows();
			}
			return $this;
		}

		/**
		 * Обновить названия городов для RU и EN столбцов таблицы ujhjljd
		 *
		 * @param string $update_field
		 * @param string $lang
		 * @param int $limit
		 * @return $this|bool|Test
		 */
		public function updateGeoCities($update_field='gc_title_ru',$lang="ru",$limit=1000){
			$ids_list = Database::select('gc_city_id')
				->from('geo_cities')
				->where("isnull({$update_field})")
				->limit($limit)
				->get()->allAsArray();

			if(!$ids_list){
				unset($ids_list);
				if($update_field == 'gc_title_ru' && $lang == 'ru'){
					return $this->updateGeoCities('gc_title_en',"en",$limit);
				}
				if($update_field == 'gc_title_en' && $lang == 'en'){
					return true;
				}
				return false;
			}

			$ids = '';
			foreach($ids_list as $item){
				$ids .= "{$item['gc_city_id']},";
			}
			$ids = trim($ids,",");

			$response_from_vk = $this->downloadDataByURL('getCitiesById',array(
				'city_ids'	=> $ids,
				'lang'		=> $lang
			));

			if(!isset($response_from_vk['response'])){
				unset($ids_list,$response_from_vk,$content,$context,$opts,$item,$ids);
				return false;
			}
			if(isset($response_from_vk['response'])){
				foreach($response_from_vk['response'] as $item_response){
					Database::update('geo_cities')
						->field($update_field,$item_response['title'])
						->where("`gc_city_id`='{$item_response['id']}'")
						->get()
						->rows();
				}
			}

			if(self::$count > 50){
				return $this;
			}

			self::$count++;

			unset($ids_list,$response_from_vk,$content,$context,$opts,$item,$ids,$item_response);
			return $this->updateGeoCities($update_field,$lang,$limit);
		}

		/**
		 * Скачать страницу
		 *
		 * @param string $action
		 * @param array $query
		 * @return mixed
		 */
		public function downloadDataByURL($action='getCitiesById',array $query){
			$query['access_token']	= $this->config->api['vk']['access_token'];
			$query['v']				= $this->config->api['vk']['v'];

			$content = http_build_query($query);
			$opts = array(
				'http'=>array(
					'method'=>"POST",
					'header'=>
						"Content-Length: ".strlen($content)."\r\n".
						"Content-Type: application/x-www-form-urlencoded\r\n",

					'content' => $content,
				)
			);
			$context = stream_context_create($opts);

			return json_decode(file_get_contents("https://api.vk.com/method/database.{$action}", false, $context),1);
		}












	}














