<?php

	namespace Core\Classes;

	class Router{

		private static $instance;

		protected $router;
		protected $request;

		protected $absolute_url;
		protected $url_array;
		protected $link_arr;
		protected $query_arr;

		protected $routes_list;

		protected $controller;
		protected $action;
		protected $params;

		private $find_route;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->router[$key])){
				return $this->router[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->router[$name] = $value;
			return $this->router[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
		}

		protected function cleanURL($url){
			return preg_replace("#{$this->config->router['url_delimiter']}+#",$this->config->router['url_delimiter'],$url);
		}

		public function parseURL($url){
			$url = $this->cleanURL(urldecode($url));
			$this->absolute_url = trim($url,'/ ');
			$this->url_array = parse_url($this->absolute_url);
			if(!isset($this->url_array['path'])){ $this->url_array['path'] = ''; }
			$this->parseQueryStr();
			return $this;
		}

		public function setRoute(){
			$this->getRoutesList()
				->searchRouteInRoutesArray();

			if(!$this->getRouterStatus()){
				$this->parseLinkStr();
			}
			return $this;
		}

		protected function getRoutesList(){
			$this->routes_list = fx_load_helper("system/assets/routes",Kernel::IMPORT_INCLUDE);
			return $this;
		}

		protected function searchRouteInRoutesArray(){
			foreach($this->routes_list as $value){
				if(!fx_status($value['status'],Kernel::STATUS_ACTIVE)){ continue; }

				$pattern = $this->preparePattern($value['url'],fx_arr($value['pattern'],'string'));
				preg_match("#{$pattern}#{$value['modifier']}",$this->url_array['path'],$result_matches);
				if(isset($result_matches[0]) && fx_equal($result_matches[0],$this->url_array['path'])){
					$this->setMainTypeRouter($value['controller'],$value['action'],array_slice($result_matches,1));
				}
			}
			return $this;
		}

		protected function preparePattern($key,$pattern){
			if(is_array($pattern)){
				return $this->prepareArrayPatterns($key,$pattern);
			}
			return $this->prepareStringPatterns($key,$pattern);
		}

		protected function prepareStringPatterns($key,$pattern){
			return preg_replace("#\[(.*?)\]#",$pattern,$key);
		}

		protected function prepareArrayPatterns($key,$pattern){
			$keys = array_merge(array('[',']'),array_keys($pattern));
			$values = array_merge(array('',''),array_values($pattern));
			return str_replace($keys,$values,$key);
		}

		protected function setMainTypeRouter($controller,$action,$params){
			$this->controller	= $controller;
			$this->action	= $action;
			$this->params	= $params;
			$this->find_route	= true;
			return $this;
		}

		protected function parseLinkStr(){
			$this->link_arr = explode($this->config->router['url_delimiter'],$this->url_array['path']);
			$this->setAlternativeRouter();
			return $this;
		}

		protected function parseQueryStr(){
			if(isset($this->url_array['query'])){
				parse_str($this->url_array['query'],$this->request);
				$this->mergeRequest();
			}
			return $this;
		}

		protected function mergeRequest(){
			foreach($this->request as $key=>$name){
				fx_set_request($key,$name);
				fx_set_get($key,$name);
			}
			return $this;
		}

		protected function setAlternativeRouter(){
			$this->controller	= !empty($this->link_arr[0]) ? $this->link_arr[0] : $this->config->router['default_controller'];
			$this->action	= isset($this->link_arr[1]) ? $this->link_arr[1] : $this->config->router['default_action'];
			$this->params	= is_array($this->link_arr) ? array_slice($this->link_arr,2) : array();
			return $this;
		}

		public function getRouterStatus(){
			return $this->find_route;
		}

		public function getController(){
			return $this->controller;
		}

		public function getAction(){
			return $this->action;
		}

		public function getParams(){
			return $this->params;
		}

		public function getRequest(){
			if(!$this->request){
				$this->parseQueryStr();
			}
			return $this->request;
		}


















	}















