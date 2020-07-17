<?php

	namespace Core\Classes\Cache;

	class JSON extends PHP{

		protected $file_extension = 'json';

		public function __construct(array $params){
			parent::__construct($params);
		}

		public function set($data){
			$this->getCacheAttributes();
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














