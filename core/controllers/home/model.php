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
				->join("links FORCE INDEX (PRIMARY) ","menu.id=links.menu_id")
				->where("menu.widget_id='{$widget_id}' AND menu.status='{$active}' AND links.status='{$active}'")
				->order('ordering')
				->get()
				->allAsArray();

			$this->cache->set($menu_links);
			return $menu_links;
		}

		public function getActiveWidgetsList(){

			$this->cache->key('files.included');

			if(($widgets_list = $this->cache->get()->array())){
				return $widgets_list;
			}

			$widgets_list = $this->select()
				->from('widgets')
				->join('widgets_active',"widgets_active.widget_id=widgets.id")
				->where("widgets_active.status = " . Kernel::STATUS_ACTIVE . " AND widgets.status=" . Kernel::STATUS_ACTIVE)
				->order('ordering','asc')
				->get()
				->allAsArray();

			$this->cache->set($widgets_list);
			return $widgets_list;
		}
















	}














