<?php

	namespace Core\Controllers\Search;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('search');
		}

		public function count($table,$query,$preparing_data){
			$result = $this->select('COUNT(*) as total');
			$result = $result->from($table);
			$result = $result->where($query);

			foreach($preparing_data as $key=>$value){
				$result = $result->data($key,$value);
			}

			$result = $result->get();
			$result = $result->itemAsArray();
			return $result['total'];
		}

		public function find($table,$query,array $fields,$preparing_data,$limit){
			$fields_string = '';
			foreach($fields as $key=>$field){
				if(!$field){ continue; }
				$fields_string .= "{$field} as {$key}, ";
			}
			$fields_string .= "p_small as image";

			$result = $this->select($fields_string);
			$result = $result->from($table);
			$result = $result->join('photos FORCE INDEX(PRIMARY)',"{$fields['image']}=p_id");
			$result = $result->where($query);
			$result = $result->order($fields['date']);
			$result = $result->sort('DESC');
			$result = $result->limit($limit);

			foreach($preparing_data as $key=>$value){
				$result = $result->data($key,$value);
			}

			$result = $result->get();
			$result = $result->allAsArray();
			return $result;
		}



















	}














