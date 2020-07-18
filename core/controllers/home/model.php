<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Kernel;
	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		private $default_geo_fields = array(
			'gc_city_id'	=> null,
			'gc_region_id'	=> null,
			'gc_country_id'	=> null,
			'gc_area'		=> null,
			'gc_title_ru'	=> null,
			'gc_title_en'	=> null,
			'gr_region_id'	=> null,
			'gr_country_id'	=> null,
			'gr_title_ru'	=> null,
			'gr_title_en'	=> null,
			'g_country_id'	=> null,
			'g_total_regions'=> null,
			'g_total_cities'=> null,
			'g_title_ru'	=> null,
			'g_title_en'	=> null,
		);

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function getMenuLinksByWidgetId($widget_id){
			$active = Kernel::STATUS_ACTIVE;

			$this->cache->key("widgets.menu.links");

			if(($menu_links = $this->cache->get()->array())){
				return $menu_links;
			}

			$menu_links = $this->select()
				->from('menu')
				->join("links FORCE INDEX (PRIMARY) ","m_id=l_menu_id")
				->where("m_widget_id='{$widget_id}' AND m_status='{$active}' AND l_status='{$active}'")
				->order('l_ordering')
				->sort()
				->get()
				->allAsArray();

			$this->cache->set($menu_links);
			return $menu_links;
		}

		public function getActiveWidgetsList(){

			$this->cache->key('widgets.active');

			if(($widgets_list = $this->cache->get()->array())){
				return $widgets_list;
			}

			$widgets_list = $this->select()
				->from('widgets')
				->join('widgets_active',"wa_widget_id=w_id")
				->where("wa_status = " . Kernel::STATUS_ACTIVE . " AND w_status=" . Kernel::STATUS_ACTIVE)
				->order('wa_ordering')
				->sort()
				->get()
				->allAsArray();

			$this->cache->set($widgets_list);
			return $widgets_list;
		}

		public function getGeoByIds($country_id,$region_id,$city_id){
			if($country_id && $region_id && $city_id){
				$result = $this->getCityById($city_id);
				return array_merge($this->default_geo_fields,(array)$result);
			}
			if($country_id && !$region_id && $city_id){
				$result = $this->getCityById($city_id);
				return array_merge($this->default_geo_fields,(array)$result);
			}
			if($country_id && $region_id && !$city_id){
				$result = $this->getRegionById($region_id);
				return array_merge($this->default_geo_fields,(array)$result);
			}
			if($country_id && !$region_id && !$city_id){
				$result= $this->getCountryById($country_id);
				return array_merge($this->default_geo_fields,(array)$result);
			}
			return $this->default_geo_fields;
		}

		public function getCountryById($country_id){
			return $this->select()
				->from('geo_countries')
				->where("g_country_id=%country_id%")
				->data('%country_id%',$country_id)
				->limit(1)
				->get()
				->itemAsArray();
		}

		public function getRegionById($region_id){
			return $this->select()
				->from('geo_regions')
				->where("gr_region_id=%region_id%")
				->join('geo_countries FORCE INDEX(PRIMARY)',"gr_country_id=g_country_id")
				->data('%region_id%',$region_id)
				->limit(1)
				->get()
				->itemAsArray();
		}

		public function getCityById($city_id){
			return $this->select()
				->from('geo_cities')
				->where("gc_city_id=%city_id%")
				->join('geo_regions FORCE INDEX(PRIMARY)',"gc_region_id=gr_region_id")
				->join('geo_countries FORCE INDEX(PRIMARY)',"gc_country_id=g_country_id")
				->data('%city_id%',$city_id)
				->limit(1)
				->get()
				->itemAsArray();
		}

		public function getGeoByName($search_string,$action){
			$method = "get{$action}ByName";
			if(method_exists($this,$method)){
				return call_user_func_array(array($this,$method),array($search_string));
			}
			return array();
		}

		public function getCountryByName($search_string){
			return $this->select()
				->from('geo_countries')
				->where("g_title_ru LIKE %country_name% OR g_title_en LIKE %country_name%")
				->data('%country_name%',"{$search_string}%")
				->limit(10)
				->get()
				->allAsArray();
		}

		public function getRegionByName($search_string,$country_id){
			$where = '';
			if($country_id){
				$where .= "g_country_id=%country_id% AND ";
			}
			return $this->select()
				->from('geo_regions')
				->where("{$where}(gr_title_ru LIKE %region_name% OR gr_title_en LIKE %region_name%)")
				->join('geo_countries FORCE INDEX(PRIMARY)',"gr_country_id=g_country_id")
				->data('%region_name%',"{$search_string}%")
				->data('%country_id%',$country_id)
				->limit(10)
				->get()
				->allAsArray();
		}

		public function getCityByName($search_string,$region_id,$country_id){
			$where = '';
			if($country_id){
				$where .= "g_country_id=%country_id% AND ";
			}
			if($region_id){
				$where .= "gr_region_id=%region_id% AND";
			}
			return $this->select()
				->from('geo_cities')
				->where("{$where}(gc_title_ru LIKE %city_name% OR gc_title_en LIKE %city_name%)")
				->join('geo_regions FORCE INDEX(PRIMARY)',"gc_region_id=gr_region_id")
				->join('geo_countries FORCE INDEX(PRIMARY)',"gc_country_id=g_country_id")
				->data('%city_name%',"{$search_string}%")
				->data('%region_id%',$region_id)
				->data('%country_id%',$country_id)
				->limit(10)
				->get()
				->allAsArray();
		}












	}














