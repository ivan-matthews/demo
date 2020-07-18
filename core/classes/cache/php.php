<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Config;
	use Core\Classes\Kernel;
	use Core\Classes\Response\Response;

	class PHP{

		const CACHE_EXPIRED_KEY = 'cache_expired_time_key';

		private $opcache_status;
		protected $params;
		protected $root;
		protected $file_extension = 'php';

		protected $key;
		protected $index;
		protected $ttl;
		protected $mark;
		protected $hash;

		protected $mark_sending;
		protected $cache_directory;
		protected $cache_filename;

		protected $trace;

		public function drop(){
			$this->key = null;
			$this->index = $this->params['index'];
			$this->ttl = $this->params['cache_ttl'];
			$this->mark = null;
			$this->hash = null;
			$this->trace = null;
			$this->mark_sending = null;
			return $this;
		}

		public function __construct(array $params){
			$this->opcache_status = ini_get('opcache.revalidate_freq');
			$this->params = $params;
			$this->root = fx_path("{$this->params['cache_dir']}/dynamic");
			$this->ttl = $this->params['cache_ttl'];
			$this->index = $this->params['index'];
		}

		protected function saveDebug($debug_time){
			if(!Config::getInstance()->core['debug_enabled']){ return $this; }
			$this->trace = $this->trace ? $this->trace : debug_backtrace();
			Response::_debug('cache')
				->index($this->index)
				->setTime($debug_time)
				->setQuery("{$this->key}:{$this->mark}")
				->setFile($this->prepareBackTrace($this->trace,1,'file'))
				->setClass($this->prepareBackTrace($this->trace,1,'class'))
				->setFunction($this->prepareBackTrace($this->trace,1,'function'))
				->setType($this->prepareBackTrace($this->trace,1,'type'))
				->setLine($this->prepareBackTrace($this->trace,1,'line'))
				->setArgs($this->prepareBackTrace($this->trace,1,'args'))
				->setTrace($this->trace);
			return $this;
		}

		private function prepareBackTrace($debug_back_trace,$index,$key){
			return isset($debug_back_trace[$index][$key]) ? $debug_back_trace[$index][$key] : null;
		}

		protected function check(){
			if(filemtime($this->cache_filename) + $this->ttl > time()){
				return true;
			}
			return false;
		}

		public function get(){
			$debug_time = microtime(true);
			$this->getCacheAttributes();
			if(file_exists($this->cache_filename) && $this->check()){
				$cache_data = $this->tryInc();
				$this->saveDebug($debug_time);
				return $cache_data;
			}
			return null;
		}
		public function set($data){
			$this->getCacheAttributes();
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
			$this->cache_filename = "{$this->cache_directory}/{$this->hash}.{$this->file_extension}";
			if($this->params['cache_enabled']){
				fx_make_dir($this->cache_directory,0777);
			}
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
		public function mark($mark){
			$this->mark_sending = true;
			$this->mark = $mark;
			return $this->hash();
		}

		protected function parseIndex(){
			if(!$this->mark_sending){
				$this->trace = debug_backtrace();
				$this->mark = isset($this->trace[$this->index]['class']) ? $this->trace[$this->index]['class'] : null;
				$this->mark .= isset($this->trace[$this->index]['type']) ? $this->trace[$this->index]['type'] : null;
				$this->mark .= isset($this->trace[$this->index]['function']) ? $this->trace[$this->index]['function'] : null;
				$this->mark .= isset($this->trace[$this->index]['args']) ? '(' . fx_implode(',',$this->trace[$this->index]['args']) . ')' : "()";
				return $this->hash();
			}
			return $this;
		}

		protected function tryInc(){
			$data = null;
			try{
				$data = fx_import_file($this->cache_filename,Kernel::IMPORT_INCLUDE);
			}catch(\Error $e){
				unlink($this->cache_filename);
				return false;
			}
			return $data;
		}


















	}














