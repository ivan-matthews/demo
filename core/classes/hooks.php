<?php

	namespace Core\Classes;

	use Core\Classes\Cache\Cache;
	use Core\Classes\Interfaces\Hooks as HooksInterface;
	use Core\Classes\Response\Response;

	/**
	 * Class Hooks
	 * @package Core\Classes
	 * @method static _run($callable_function,...$arguments_list)
	 * @method static _instead($callable_function,...$arguments_list)
	 * @method static _after($callable_function,...$arguments_list)
	 * @method static _before($callable_function,...$arguments_list)
	 */
	class Hooks implements HooksInterface{

		private static $instance;

		private $cache;
		private $config;
		protected $hooks_dir;
		protected $hooks_list = array();
		protected $all_hooks = array();

		public static function __callStatic($method,$arguments){
			$method_name = trim($method,'_');
			$self_object = self::getInstance();
			if(method_exists($self_object,$method_name)){
				return call_user_func(array($self_object,$method_name),...$arguments);
			}
			return null;
		}

		/** @return HooksInterface */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->hooks_dir = fx_path('system/hooks_list');
			$this->cache = new Cache();
			$this->cache->key('files.included')->mark('hooks')->ttl(86400 * 100);
			$this->getHooksList();
		}

		private function getHooksList(){
			$this->cache->get();
			if(($this->hooks_list = $this->cache->array())){
				return $this;
			}
			$this->scanHooksDir();
			$this->sortHooksByRelevance();
			$this->cache->set($this->hooks_list);
			return $this;
		}

		private function getAllHooksList(){	// ???
			$this->cache->get();
			if(($this->all_hooks = $this->cache->array())){
				return $this;
			}
			$this->scanHooksDir();	// $this->getHooksList() ???
			$this->sortHooksByRelevance();
			$this->cache->set($this->all_hooks);
			return $this;
		}

		private function scanHooksDir(){
			if(is_dir($this->hooks_dir)){
				$hooks_files_list = scandir($this->hooks_dir);
				foreach($hooks_files_list as $file){
					if($file == '.' || $file == '..'){ continue; }
					$hooks_file = fx_import_file("{$this->hooks_dir}/{$file}",Kernel::IMPORT_INCLUDE);
					$this->includeHooksFile($file,$hooks_file);
				}
			}
			return $this->setCustomHooksFiles();
		}

		private function setCustomHooksFiles(){
			$controller_folder = fx_path('core/controllers');
			$hooks_files_list = scandir($controller_folder);
			foreach($hooks_files_list as $file){
				if($file == '.' || $file == '..'){ continue; }
				$hooks_file = "{$controller_folder}/{$file}/config/hooks.php";
				if(is_readable($hooks_file)){
					$hooks_file = fx_import_file($hooks_file,Kernel::IMPORT_INCLUDE);
					$this->includeHooksFile($file,$hooks_file);
				}
			}
			return $this;
		}

		private function includeHooksFile($file,$hooks_file){
			$this->all_hooks[pathinfo($file,PATHINFO_FILENAME)] = $hooks_file;
			foreach($hooks_file as $key=>$item){
				$ready = fx_equal($item['status'],Kernel::STATUS_ACTIVE) && method_exists($item['class'],$item['method']);
				if(!$ready){ continue; }
				$this->hooks_list[$key][$this->getNewIndex($key,$item['relevance'])] = $item;
			}
			return $this;
		}

		private function getNewIndex($hook_key,$hook_index){
			if(!isset($this->hooks_list[$hook_key][$hook_index])){
				return $hook_index;
			}
			return $this->makeNewIndex($hook_key,$hook_index + 1);
		}

		private function makeNewIndex($hook_key,$hook_index){
			if(!isset($this->hooks_list[$hook_key][$hook_index])){
				return $hook_index;
			}
			return $this->makeNewIndex($hook_key,$hook_index+1);
		}

		private function sortHooksByRelevance(){
			foreach($this->hooks_list as $key=>$value){
				ksort($this->hooks_list[$key]);
			}
			return $this;
		}

		public function run($hook_name,...$arguments_list){
			$time = microtime(true);
			$hook_name = "{$hook_name}_hook";
			$result = array();
			if(isset($this->hooks_list[$hook_name])){
				foreach($this->hooks_list[$hook_name] as $list){
					$hook_obj = new $list['class'](...$arguments_list);
					$result[] = call_user_func(array($hook_obj,$list['method']),...$arguments_list);

					if($this->config->core['debug_enabled']){
						$debug_back_trace = debug_backtrace();
						Response::_debug('hooks')
							->setTime($time)
							->setTrace($debug_back_trace)
							->setFile($this->prepareBackTrace($debug_back_trace,1,'file'))
							->setClass($this->prepareBackTrace($debug_back_trace,1,'class'))
							->setFunction($this->prepareBackTrace($debug_back_trace,1,'function'))
							->setType($this->prepareBackTrace($debug_back_trace,1,'type'))
							->setLine($this->prepareBackTrace($debug_back_trace,1,'line'))
							->setArgs($this->prepareBackTrace($debug_back_trace,1,'args'))
							->setQuery("{$list['class']}::{$list['method']}()");
					}
				}
			}
			return $result;
		}

		private function prepareBackTrace($debug_back_trace,$index,$key){
			return isset($debug_back_trace[$index][$key]) ? $debug_back_trace[$index][$key] : null;
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

		public function getHooksArray(){
			return $this->getAllHooksList()->all_hooks;
		}

		public function getHooks(){
			return $this->getHooksList()->hooks_list;
		}


















	}














