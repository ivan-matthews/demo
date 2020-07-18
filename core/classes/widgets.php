<?php

	namespace Core\Classes;
	
	use Core\Classes\Cache\Cache;
	use Core\Classes\Database\Database;
	use Core\Classes\Response\Response;
	
	class Widgets{

		private static $instance;

		protected $widgets_dir;
		protected $widgets_list = array();

		private $response;
		private $cache;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->cache = Cache::getInstance();
			$this->response = Response::getInstance();
			$this->widgets_dir = fx_path('system/widgets_list');
			$this->getWidgetsList();
		}

		private function getWidgetsList(){
			$this->cache->key('files.included')->get();
			if(($this->widgets_list = $this->cache->array())){
				return $this;
			}
			$this->getWidgetsFromDB();
			$this->cache->set($this->widgets_list);
			return $this;
		}

		private function getWidgetsFromDB(){
			$this->widgets_list = Database::select()
				->from('widgets')
				->where("`status` = " . Kernel::STATUS_ACTIVE)
				->order('ordering','asc')
				->get()
				->allAsArray();
			return $this;
		}

		public function execute(){
			$access = new Access();

			foreach($this->widgets_list as $key=>$widget){
				$widget['groups_disabled'] = fx_arr($widget['groups_disabled']);
				$widget['pages_disabled'] = fx_arr($widget['pages_disabled']);
				$widget['groups_enabled'] = fx_arr($widget['groups_enabled']);
				$widget['pages_enabled'] = fx_arr($widget['pages_enabled']);

				$access->disableGroups($widget['groups_disabled']);
				$access->disablePages($widget['pages_disabled']);
				$access->enableGroups($widget['groups_enabled']);
				$access->enablePages($widget['pages_enabled']);
				if(!$access->granted()){
					$access->drop();
					continue;
				}

				$widget_object = new $widget['class']($widget);
				$widget_execute_result = call_user_func(array($widget_object,$widget['method']));

				$this->response->debug('widgets')
					->setQuery("{$widget['class']}::{$widget['method']}()");

				$this->response->widget($widget['position'])
					->set('data',$widget_execute_result)
					->set('params',array(
						'position'		=> $widget['position'],
						'template'		=> $widget['template'],
//						'ordering'		=> $widget['ordering'],
					));
			}
			return $this;
		}

		public function getWidgets(){
			return $this->widgets_list;
		}
















	}














