<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Response;

	class Memcached{

		private $params;

		private $key;
		private $index;
		private $ttl;
		private $mark;
		private $hash;
		private $trace;

		private $cache_prefix;
		private $cache_key;

		/** @var \Memcached */
		private $memcached;

		public function __construct($params){
			$this->cache_prefix = 'cache' . sprintf('%u', crc32('m.c'));
			$this->params = $params;
			$this->ttl = $this->params['cache_ttl'];
			$this->index = 4;
			$this->connect();
		}

		public function __destruct(){
			$this->memcached->quit();
		}

		private function connect(){
			try{
				$this->memcached = new \Memcached();
				$this->memcached->addServer($this->params['memcached']['host'],$this->params['memcached']['port']);
				return $this;
			}catch(\Error $e){
				return false;
			}
		}

		protected function saveDebug($debug_time){
			Response::_debug('cache')
				->index($this->index)
				->set('result',$this->key)
				->setTime($debug_time)
				->setQuery($this->mark)
				->setTrace($this->trace);
			return $this;
		}

		public function key($key){
			$this->key = $key;
			return $this;
		}
		public function index($index){
			$this->index = $index;
			return $this;
		}
		public function ttl($ttl){
			$this->ttl = $ttl;
			return $this;
		}
		public function hash(){
			$this->hash = md5($this->mark);
			return $this;
		}
		public function get(){
			$this->getCacheAttributes();
			$debug_time = microtime(true);
			$data_result = $this->memcached->get($this->cache_key);
			if($data_result){
				$data_result = unserialize($data_result);
				$this->saveDebug($debug_time);
				return $data_result;
			}
			return null;
		}
		public function set(array $data){
			$this->getCacheAttributes();
			$data = serialize($data);
			$this->memcached->set($this->cache_key, $data, time() + $this->ttl);
			return null;
		}
		public function clear(){
			$this->memcached->flush();
			return null;
		}

		private function parseIndex(){
			$this->trace = debug_backtrace();
			$this->mark = isset($this->trace[$this->index]['class']) ? $this->trace[$this->index]['class'] : null;
			$this->mark .= isset($this->trace[$this->index]['type']) ? $this->trace[$this->index]['type'] : null;
			$this->mark .= isset($this->trace[$this->index]['function']) ? $this->trace[$this->index]['function'] : null;
			$this->mark .= isset($this->trace[$this->index]['args']) ? '(' . fx_implode(',',$this->trace[$this->index]['args']) . ')' : "()";
			return $this->hash();
		}

		private function getCacheAttributes(){
			$this->parseIndex();
			$this->cache_key = "{$this->cache_prefix}.{$this->key}.{$this->hash}";
			return $this;
		}




















	}














