<?php

	namespace Core\Classes;

	use ReflectionMethod as Reflect;

	class Kernel{

		const IMPORT_REQUIRE		= 0;
		const IMPORT_REQUIRE_ONCE	= 1;
		const IMPORT_INCLUDE		= 2;
		const IMPORT_INCLUDE_ONCE	= 3;

		const STATUS_INACTIVE 	= 0;
		const STATUS_ACTIVE 	= 1;
		const STATUS_LOCKED 	= 2;
		const STATUS_BLOCKED 	= 3;
		const STATUS_DELETED 	= 4;

		private static $instance;

		protected $kernel=array();

		private $user;

		protected $config;
		protected $request;
		protected $router;
		protected $response;
		protected $router_find_in_list;

		protected $controller;
		protected $action;
		protected $params;
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
			$action = call_user_func(array($this->action_class_name,'getInstance'));
			$method = "method{$this->request_method}";
			if(method_exists($action,$method)){
				$this->checkActionAccess();
				if($this->action_access->denied()){
					return $this->setDeniedStatus();
				}
				if($this->countActionArguments($action,$method,$this->params)){
					if(call_user_func_array(array($action,$method),$this->params)){
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
			$this->setControllerConfig();
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
			if($this->user->isUnLogged()){
				$this->response->setResponseCode(401);
				return true;
			}
			$this->response->setResponseCode(403);
			return true;
		}






	}














