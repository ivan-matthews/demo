<?php

	namespace Core\Classes;
	
	use Core\Classes\Cache\Cache;
	use Core\Controllers\Home\Model;
	use Core\Classes\Response\Response;
	
	class Widgets{

		private static $instance;

		protected $widgets_dir;
		protected $widgets_list = array();

		private $response;
		private $cache;
		private $model;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->cache = Cache::getInstance();
			$this->response = Response::getInstance();
			$this->model = Model::getInstance();
			$this->config = Config::getInstance();
			$this->widgets_dir = fx_path('system/widgets_list');
			$this->getWidgetsFromDB();
		}

		private function getWidgetsFromDB(){
			$this->widgets_list = $this->model->getActiveWidgetsList();
			return $this;
		}

		public function execute(){
			$time = microtime(true);
			$access = new Access();

			if(!$this->widgets_list){ return false; }

			foreach($this->widgets_list as $key=>$widget){

				if(!fx_equal(Kernel::STATUS_ACTIVE,$widget['w_status'])){ continue; }

				$access->disableGroups($widget['wa_groups_disabled']);
				$access->disablePages($widget['wa_pages_disabled']);
				$access->enableGroups($widget['wa_groups_enabled']);
				$access->enablePages($widget['wa_pages_enabled']);

				if(!$access->granted()){
					$access->drop();
					continue;
				}

				$widget_object = new $widget['w_class']($widget);
				$widget_execute_result = call_user_func(array($widget_object,$widget['w_method']));

				if($this->config->core['debug_enabled']){
					$debug_back_trace = debug_backtrace();
					$this->response->debug('widgets')
						->setTime($time)
						->setTrace($debug_back_trace)
						->setFile($this->prepareBackTrace($debug_back_trace,0,'file'))
						->setClass($this->prepareBackTrace($debug_back_trace,0,'class'))
						->setFunction($this->prepareBackTrace($debug_back_trace,0,'function'))
						->setType($this->prepareBackTrace($debug_back_trace,0,'type'))
						->setLine($this->prepareBackTrace($debug_back_trace,0,'line'))
						->setArgs($this->prepareBackTrace($debug_back_trace,1,'args'))
						->setQuery("{$widget['w_class']}::{$widget['w_method']}()");
				}

				$this->response->widget($widget)
					->set('data',$widget_execute_result)
					->set('params',$widget)
					->add();
			}
			return $this;
		}

		private function prepareBackTrace($debug_back_trace,$index,$key){
			return isset($debug_back_trace[$index][$key]) ? $debug_back_trace[$index][$key] : null;
		}

		public function getWidgets(){
			return $this->widgets_list;
		}
















	}














