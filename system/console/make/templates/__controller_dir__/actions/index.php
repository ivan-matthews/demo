<?php

	namespace Core\Controllers\__controller_namespace__\Actions;

	use Core\Classes\Hook;
	use Core\Classes\Request;
	use Core\Classes\Response;
	use Core\Controllers\__controller_namespace__\Config;
	use Core\Controllers\__controller_namespace__\Controller;
	use Core\Controllers\__controller_namespace__\Model;

	class Index extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		protected $config;

		/** @var Model */
		protected $model;

		/** @var \Core\Classes\Config */
		protected $site_config;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

		/** @var \Core\Classes\User */
		protected $user;

		/** @var Hook */
		protected $hook;

		/** @var array */
		private $__action_property__;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->__action_property__[$key])){
				return $this->__action_property__[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->__action_property__[$name] = $value;
			return $this->__action_property__[$name];
		}

		public function __construct(){
			parent::__construct();
		}

		public function __destruct(){

		}

		public function methodGet(){
//			$this->hook->before('__controller_property_____action_property___get',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___get',...func_get_args());
			return false;
		}

		public function methodPost(){
//			$this->hook->before('__controller_property_____action_property___post',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___post',...func_get_args());
			return false;
		}

		public function methodPut(){
//			$this->hook->before('__controller_property_____action_property___put',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___put',...func_get_args());
			return false;
		}

		public function methodHead(){
//			$this->hook->before('__controller_property_____action_property___head',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___head',...func_get_args());
			return false;
		}

		public function methodTrace(){
//			$this->hook->before('__controller_property_____action_property___trace',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___trace',...func_get_args());
			return false;
		}

		public function methodPatch(){
//			$this->hook->before('__controller_property_____action_property___patch',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___patch',...func_get_args());
			return false;
		}

		public function methodOptions(){
//			$this->hook->before('__controller_property_____action_property___options',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___options',...func_get_args());
			return false;
		}

		public function methodConnect(){
//			$this->hook->before('__controller_property_____action_property___connect',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___connect',...func_get_args());
			return false;
		}

		public function methodDelete(){
//			$this->hook->before('__controller_property_____action_property___delete',...func_get_args());
//			$this->hook->after('__controller_property_____action_property___delete',...func_get_args());
			return false;
		}




















	}














