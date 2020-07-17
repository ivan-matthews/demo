<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Response;

	class Memcached{

		const CACHE_EXPIRED_KEY = 'cache_expired_time_key';

		private $params;
		private $cache_prefix;
		/** @var \Memcached */
		private $memcached;

		private $key;
		private $index;
		private $ttl;
		private $mark;
		private $hash;
		private $trace;
		private $prefix_key;
		private $cache_key;
		private $mark_sending;

		public function drop(){
			$this->key = null;
			$this->index = $this->params['index'];
			$this->ttl = $this->params['cache_ttl'];
			$this->mark = null;
			$this->hash = null;
			$this->trace = null;
			$this->prefix_key = null;
			$this->cache_key = null;
			$this->mark_sending = true;
			return $this;
		}

		public function __construct($params){
			$this->params = $params;
			$this->ttl = $this->params['cache_ttl'];
			$this->index = $this->params['index'];
			$this->cache_prefix = 'namespace.' . sprintf('%u', crc32($this->params['site_host']));
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
				->set('result',$this->cache_key)
				->setTime($debug_time)
				->setQuery("{$this->key}:{$this->mark}")
				->setTrace($this->trace ? $this->trace : debug_backtrace());
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

		protected function check($cache_expired_timer){
			if($cache_expired_timer + $this->ttl > time()){
				return true;
			}
			return false;
		}

		public function get(){
			$this->getCacheAttributes();
			$debug_time = microtime(true);
			$data_result = $this->memcached->get($this->cache_key);
			if($data_result){
				$data_result = unserialize($data_result);
				if($this->check($data_result[self::CACHE_EXPIRED_KEY])){
					$this->saveDebug($debug_time);
					return $data_result;
				}
			}
			return null;
		}
		public function set(array $data){
			$timer = time();
			$this->getCacheAttributes();
			$data[self::CACHE_EXPIRED_KEY] = $timer;
			$data = serialize($data);
			$this->memcached->set($this->cache_key, $data, $timer + $this->ttl);
			return null;
		}
		public function clear(){
			$this->getCacheAttributes();
			if($this->key){
				$this->clearWithKey();
				return null;
			}
			$this->memcached->flush();
			return null;
		}

		private function clearWithKey(){
			$cache_keys = $this->memcached->getAllKeys();
			if($cache_keys){
				foreach($cache_keys as $key=>$value){
					if(strpos($value,$this->prefix_key) !== false){
						$this->memcached->delete($value);
					}
				}
			}
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

		private function getCacheAttributes(){
			$this->parseIndex();
			$this->prefix_key = "{$this->cache_prefix}.{$this->key}";
			$this->cache_key = "{$this->prefix_key}.{$this->hash}";
			return $this;
		}




















	}














