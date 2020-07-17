<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Response;

	class Files{

		const CACHE_EXPIRED_TIME_KEY = 'cache_expired_time_key';

		protected $params;
		protected $key;
		protected $index;
		protected $ttl;
		protected $mark;
		protected $hash;

		protected $root;
		protected $cache_directory;
		protected $cache_filename;

		protected $trace;

		public function __construct(array $params){
			$this->params = $params;
			$this->root = fx_path("{$this->params['cache_dir']}/dynamic");
			$this->ttl = $this->params['cache_ttl'];
			$this->index = 4;
		}

		protected function saveDebug($debug_time){
			Response::_debug('cache')
				->index($this->index)
				->set('result',$this->cache_filename)
				->setTime($debug_time)
				->setQuery($this->mark)
				->setTrace($this->trace);
			return $this;
		}

		public function get(){
			$debug_time = microtime(true);
			$this->getCacheAttributes();
			if(file_exists($this->cache_filename)){
				$cache_data = $this->tryInc();
				// filemtime($this->cache_filename), иначе отключать OPCache
				if($cache_data[self::CACHE_EXPIRED_TIME_KEY] + $this->ttl > time()){
					$this->saveDebug($debug_time);
					unset($cache_data[self::CACHE_EXPIRED_TIME_KEY]);
					return $cache_data;
				}
			}
			return null;
		}
		public function set(array $data){
			$this->getCacheAttributes();
			$data[self::CACHE_EXPIRED_TIME_KEY] = time();
			file_put_contents($this->cache_filename, fx_php_encode($data));
			return null;
		}
		public function clear(){
			$this->getCacheAttributes();
			fx_scandir_callback($this->cache_directory,function($find){
				if(is_file($find)){
					unlink($find);
					return true;
				}
				rmdir($find);
				return true;
			});
			return true;
		}

		protected function getCacheAttributes(){
			$this->parseIndex();
			$this->cache_directory = "{$this->root}/{$this->key}";
			$this->cache_filename = "{$this->cache_directory}/{$this->hash}.php";
			fx_make_dir($this->cache_directory,0777);
			return $this;
		}

		public function key($key){
			$this->key = str_replace('.',DIRECTORY_SEPARATOR,$key);
			return $this;
		}
		public function index($index){
			$this->index = $index;
			return $this->parseIndex();
		}
		public function ttl($ttl){
			$this->ttl = $ttl;
			return $this;
		}
		public function hash(){
			$this->hash = md5($this->mark);
			return $this;
		}

		protected function parseIndex(){
			$this->trace = debug_backtrace();
			$this->mark = isset($this->trace[$this->index]['class']) ? $this->trace[$this->index]['class'] : null;
			$this->mark .= isset($this->trace[$this->index]['type']) ? $this->trace[$this->index]['type'] : null;
			$this->mark .= isset($this->trace[$this->index]['function']) ? $this->trace[$this->index]['function'] : null;
			$this->mark .= isset($this->trace[$this->index]['args']) ? '(' . fx_implode(',',$this->trace[$this->index]['args']) . ')' : "()";
			return $this->hash();
		}

		protected function tryInc(){
			$data = null;
			try{
				$data = fx_import_file($this->cache_filename);
			}catch(\Error $e){
				unlink($this->cache_filename);
				return false;
			}
			return $data;
		}


















	}














