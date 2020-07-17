<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Response;

	class Mongo{

		const DEFAULT_KEY = 'mongo_key';
		const DATABASE_NAME = 'mongo_database';
		const CACHE_EXPIRED_KEY = 'cache_expired_time_key';

		private $params;
		/** @var \MongoDB\Client */
		private $mongo;
		private $db_name;
		/** @var \MongoDB\Collection */
		private $collection;

		private $key;
		private $index;
		private $ttl;
		private $mark;
		private $hash;
		private $trace;

		public function __construct($params){
			$this->params = $params;
			$this->ttl = $this->params['cache_ttl'];
			$this->index = 4;
			$this->key = self::DEFAULT_KEY;
			$this->db_name = self::DATABASE_NAME;
			$this->connect();
		}

		public function __destruct(){

		}

		private function connect(){
			$link = "mongodb://";
			$link .= $this->params['mongo']['user'] ?"{$this->params['mongo']['user']}:":'';
			$link .= $this->params['mongo']['pass'] ?"{$this->params['mongo']['pass']}@":'';
			$link .= "{$this->params['mongo']['host']}:";
			$link .= $this->params['mongo']['port'];
			try{
				$this->mongo = new \MongoDB\Client($link);
				return $this;
			}catch(\Exception $e){
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
			$this->key = $key ? $key : self::DEFAULT_KEY;
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
			$debug_time = microtime(true);
			$this->getCacheAttributes();
			$result_data = $this->collection->findOne(array('data_id_hash' => $this->hash));
			$data_array = fx_arr($result_data['data']);
			if(isset($data_array[self::CACHE_EXPIRED_KEY]) && $data_array[self::CACHE_EXPIRED_KEY] + $this->ttl > time()){
				$this->saveDebug($debug_time);
				unset($data_array[self::CACHE_EXPIRED_KEY]);
				return $data_array;
			}
			$this->collection->deleteMany(array('data_id_hash' => $this->hash));
			return null;
		}
		public function set(array $data){
			$this->getCacheAttributes();
			$data[self::CACHE_EXPIRED_KEY] = time();
			$this->collection->insertOne(array('data_id_hash' => $this->hash, 'data' => $data));
			return null;
		}
		public function clear(){
//			$this->mongo->dropDatabase($this->db_name);
			$this->getCacheAttributes();
			$this->collection->drop();
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
			$this->collection = $this->mongo->{$this->db_name}->{$this->key};
			return $this;
		}




















	}














