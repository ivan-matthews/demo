<?php

	namespace Core\Classes;

	use Core\Classes\Cache\Cache;
	use ReflectionMethod as Reflect;
	use Core\Classes\Response\Response;

	class Kernel{

		const IMPORT_REQUIRE		= 0;
		const IMPORT_REQUIRE_ONCE	= 1;
		const IMPORT_INCLUDE		= 2;
		const IMPORT_INCLUDE_ONCE	= 3;

		const STATUS_INACTIVE 	= 0;	// отключено
		const STATUS_ACTIVE 	= 1;	// активно
		const STATUS_LOCKED 	= 2;	// закрыто
		const STATUS_BLOCKED 	= 3;	// заблокировано
		const STATUS_DELETED 	= 4;	// удалено

		private static $instance;

		private $kernel=array();

		private $user;
		private $hooks;
		private $cache;

		protected $config;
		protected $request;
		protected $router;
		protected $response;
		protected $router_find_in_list;

		protected $controller;
		protected $action;
		protected $params = array();
		protected $request_method;

		protected $controller_namespace;
		protected $controller_class_name;
		protected $controller_config;
		protected $action_namespace;
		protected $action_class_name;

		private $controller_config_object;
		private $controller_params;
		/** @var  Access */
		private $controller_access;
		/** @var  Access */
		private $action_access;
		private $action_params;

		public $link_replacer_list = array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->kernel[$key])){
				return $this->kernel[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->kernel[$name] = $value;
			return $this->kernel[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->router = Router::getInstance();
			$this->request = Request::getInstance();
			$this->response = Response::getInstance();
			$this->user = User::getInstance();
			$this->hooks = Hooks::getInstance();
			$this->cache = new Cache();
			$this->cache->key('files.included')->mark('replace_links')->ttl(86400 * 100);
		}

		public function loadLinkReplaceList(){
			$this->cache->get();
			if(($this->link_replacer_list = $this->cache->array())){
				return $this;
			}

			$this->link_replacer_list = fx_import_file(fx_path('system/assets/links_replace.php'));
			$this->loadCustomLinkReplaceList();

			$this->cache->set($this->link_replacer_list);
			return $this;
		}

		protected function loadCustomLinkReplaceList(){
			$controllers_dir = fx_path('core/controllers');
			foreach(scandir($controllers_dir) as $controller){
				if($controller == '.' || $controller == '..'){ continue; }
				$replace_list_file = "{$controllers_dir}/{$controller}/config/links_replace.php";
				if(is_readable($replace_list_file)){
					$this->link_replacer_list = array_merge($this->link_replacer_list, fx_import_file($replace_list_file));
				}
			}
			return $this;
		}

		public function getCurrentController(){
			return $this->controller;
		}

		public function getCurrentAction(){
			return $this->action;
		}

		public function getCurrentParams(){
			return $this->params;
		}

		public function setProperty(){
			$this->router_find_in_list = $this->router->getRouterStatus();
			$this->request_method = $this->request->getRequestMethod();
			$this->controller = $this->router->getController();
			$this->action = $this->router->getAction();
			$this->params = $this->router->getParams();
			return $this;
		}

		public function setControllerParams(){
			$this->controller_namespace = "\\Core\\Controllers\\{$this->controller}";
			$this->controller_class_name = "{$this->controller_namespace}\\Controller";
			$this->controller_config = "{$this->controller_namespace}\\Config";
			return $this;
		}

		public function setActionParams(){
			$this->action_namespace = "{$this->controller_namespace}\\Actions";
			$this->action_class_name = "{$this->action_namespace}\\{$this->action}";
			return $this;
		}

		public function loadSystem(){
			if($this->controllerExists()){
				$this->setControllerConfig();
				if(!fx_equal($this->controller_config_object->status,self::STATUS_ACTIVE)){
					return $this->response->setResponseCode(404);
				}
				$this->checkControllerAccess();
				if($this->controller_access->denied()){
					return $this->setDeniedStatus();
				}
				if($this->actionExists()){
					if($this->loadAction()){
						return true;
					}
					return false;
				}
				if(!$this->router_find_in_list){
					if($this->loadItemAction()){
						return true;
					}
					return false;
				}
			}
			return $this->response->setResponseCode(404);
		}

		protected function controllerExists(){
			if(class_exists($this->controller_class_name)){
				return true;
			}
			return false;
		}

		protected function actionExists(){
			if(class_exists($this->action_class_name)){
				return true;
			}
			return false;
		}

		protected function loadAction(){
			$method = "method{$this->request_method}";
			if(method_exists($this->action_class_name,$method)){
				$action = call_user_func(array($this->action_class_name,'getInstance'));
				$this->checkActionAccess();
				if($this->action_access->denied()){
					return $this->setDeniedStatus();
				}
				if($this->countActionArguments($action,$method,$this->params)){
					$hook_key = strtolower("{$this->controller}_{$this->action}");
					$this->hooks->before($hook_key,...$this->params);
					if($this->hooks->instead($hook_key,...$this->params)){
						$this->hooks->after($hook_key,...$this->params);
						return true;
					}
					if(call_user_func_array(array($action,$method),$this->params)){
						$this->hooks->after($hook_key,...$this->params);
						return true;
					}
					$this->response->setResponseCode(404);
					return true;
				}
				$this->response->setResponseCode(404);
				return true;
			}
			$this->response->setResponseCode(405);
			return false;
		}

		protected function loadItemAction(){
			array_unshift($this->params,$this->action);
			$this->action = 'item';
			$this->setActionParams();
			if($this->actionExists()){
				return $this->loadAction();
			}
			return false;
		}

		private function countActionArguments($object,$method,$params){
			$total_params = count($params);
			$reflection = new Reflect($object,$method);
			if($reflection->getNumberOfParameters() < $total_params){ return false; }
			if($reflection->getNumberOfRequiredParameters() > $total_params){ return false; }
			return true;
		}

		private function setControllerConfig(){
			$this->controller_config_object = call_user_func(array($this->controller_config,'getInstance'));
			return $this;
		}

		private function checkControllerAccess(){
			$this->controller_params = $this->controller_config_object->controller;
			$this->controller_access = new Access();
			$this->controller_access->enableGroups($this->controller_params['groups_enabled']);
			$this->controller_access->disableGroups($this->controller_params['groups_disabled']);
			return $this;
		}

		private function checkActionAccess(){
			$this->action_params = $this->controller_config_object->actions;
			$this->action_access = new Access();
			if(isset($this->action_params[$this->action])){
				$this->action_params = $this->action_params[$this->action];
				$this->action_access->enableGroups($this->action_params['groups_enabled']);
				$this->action_access->disableGroups($this->action_params['groups_disabled']);
			}
			return $this;
		}

		private function setDeniedStatus(){
			if($this->user->guest()){
				$this->response->setResponseCode(401);
				return true;
			}
			$this->response->setResponseCode(403);
			return true;
		}

		public static function classExistsFromFile($file_path){
			$path_info_array = pathinfo($file_path);
			$file_class = str_replace(array(ROOT,'/'),array('',"\\"),"{$path_info_array['dirname']}/{$path_info_array['filename']}");
			return class_exists($file_class);
		}




	}














