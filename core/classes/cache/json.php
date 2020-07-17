<?php

	namespace Core\Classes\Cache;

	class Json extends Files{

		protected $file_extension = 'json';

		public function __construct(array $params){
			parent::__construct($params);
		}

		public function get(){
			$debug_time = microtime(true);
			$this->getCacheAttributes();
			if(file_exists($this->cache_filename)){
				$cache_data = $this->tryInc();
				if($cache_data[self::CACHE_EXPIRED_TIME_KEY] + $this->ttl > time()){
					$this->saveDebug($debug_time);
					unset($cache_data[self::CACHE_EXPIRED_TIME_KEY]);
					return $cache_data;
				}
			}
			return null;
		}

		public function set($data){
			$this->getCacheAttributes();
			$data[self::CACHE_EXPIRED_TIME_KEY] = time();
			file_put_contents($this->cache_filename, json_encode($data,JSON_PRETTY_PRINT));
			return null;
		}

		protected function tryInc(){
			$data = null;
			try{
				$data = file_get_contents($this->cache_filename);
			}catch(\Error $e){
				unlink($this->cache_filename);
				return false;
			}
			return json_decode($data,true);
		}


















	}














