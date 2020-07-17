<?php

	namespace Core\Classes;
	use Core\Classes\Cache\Cache;

	/**
	 * Class Hook
	 * @package Core\Classes
	 * @method static _run($callable_function,...$arguments_list)
	 * @method static _instead($callable_function,...$arguments_list)
	 * @method static _after($callable_function,...$arguments_list)
	 * @method static _before($callable_function,...$arguments_list)
	 */
	class Hook{

		private static $instance;
		private $cache;
		protected $hooks_dir;
		protected $hooks_list = array();

		public static function __callStatic($method,$arguments){
			$method_name = trim($method,'_');
			$self_object = self::getInstance();
			if(method_exists($self_object,$method_name)){
				return call_user_func(array($self_object,$method_name),...$arguments);
			}
			return null;
		}

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->cache = Cache::getInstance();
			$this->hooks_dir = fx_path('system/hooks_list');
			$this->getHooksList();
		}

		private function getHooksList(){
//			$this->cache->key()->clear();
			$this->cache->key('hooks.all')->mark('get.all.hooks.list')->get();
			if(($this->hooks_list = $this->cache->array())){
				return $this;
			}
			$this->scanHooksDir();
			$this->cache->set($this->hooks_list)->drop();
			return $this;
		}

		private function scanHooksDir(){
			foreach(scandir($this->hooks_dir) as $file){
				if($file == '.' || $file == '..' || is_dir("{$this->hooks_dir}/{$file}")){ continue; }
				foreach(fx_import_file("{$this->hooks_dir}/{$file}",Kernel::IMPORT_INCLUDE_ONCE) as $key=>$item){
					if(!fx_equal($item['status'],Kernel::STATUS_ACTIVE)){ continue; }
					$this->hooks_list[$key][] = $item;
				}
			}
			return $this;
		}

		public function run($hook_name,...$arguments_list){
			$result = array();
			if(isset($this->hooks_list[$hook_name])){
				foreach($this->hooks_list[$hook_name] as $list){
					if(class_exists($list['class'])){
						$hook_obj = new $list['class'];
						$result = call_user_func(array($hook_obj,$list['method']),...$arguments_list);
					}
				}
			}
			return $result;
		}

		public function before($hook_name,...$arguments_list){
			$hook_name = "{$hook_name}_before";
			return $this->run($hook_name,...$arguments_list);
		}

		public function instead($hook_name,...$arguments_list){
			$hook_name = "{$hook_name}_instead";
			return $this->run($hook_name,...$arguments_list);
		}

		public function after($hook_name,...$arguments_list){
			$hook_name = "{$hook_name}_after";
			return $this->run($hook_name,...$arguments_list);
		}


















	}














