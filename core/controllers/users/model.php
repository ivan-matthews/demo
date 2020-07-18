<?php

	namespace Core\Controllers\Users;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

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
		}

		public function updateDateLog($user_id,$date_log){
			$this->update('users')
				->field('date_log',$date_log)
				->where("`id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this;
		}

		public function countAllUsers($query_suffix=null){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(id) as total')->from('users')
				->where($query_suffix)
				->get()->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

		public function getAllUsers($limit=15,$offset=0,$query_suffix=null,$order='date_created',$sort='DESC'){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result;
			}

			$result = $this->select()
				->from('users')
				->where($query_suffix)
				->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();

			$this->cache->set($result);
			return $result;
		}



















	}














