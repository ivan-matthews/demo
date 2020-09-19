<?php

	namespace Core\Controllers\Sitemap;

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
			$this->cache->key('sitemap');
		}

		public function __destruct(){

		}

		public function countData($table,$count_field,$where){
			$result = $this->select("COUNT({$count_field}) as total")
				->from($table)
				->where($where)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getData($table,$selectable_fields,$where,$limit,$offset,$order_field){
			$result = $this->select(...array_values($selectable_fields))
				->from($table)
				->where($where)
				->limit($limit)
				->offset($offset)
				->order($order_field)
				->sort('ASC')
				->get()
				->allAsArray();
			return $result;
		}


















	}














