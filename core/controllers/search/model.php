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
			$result = $this->select('COUNT(*) as total')
				->from($table)
				->where($query)
				->prepare($preparing_data)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function find($table,$query,array $fields,$preparing_data,$order,$limit,$offset){
			$fields_string = '';
			foreach($fields as $key=>$field){
				if(!$field){ continue; }
				$fields_string .= "{$field} as {$key}, ";
			}
			$fields_string .= "p_small as image";

			$result = $this->select($fields_string)
				->from($table)
				->join('photos FORCE INDEX(PRIMARY)',"{$fields['image']}=p_id")
				->where($query)
				->order($order ? $order : $fields['date'])
				->sort('DESC')
				->limit($limit)
				->offset($offset)
				->prepare($preparing_data)
				->get()
				->allAsArray();

			return $result;
		}



















	}














