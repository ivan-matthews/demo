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

		public function countAllUsers($query_suffix=null,$replaced_data=array()){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(u_id) as total')->from('users')
				->where($query_suffix);

			foreach($replaced_data as $key=>$value){
				$result->data($key,$value);
			}

			$result = $result->get()->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

		public function getAllUsers($limit=15,$offset=0,$query_suffix=null,$order='u_date_created',$sort='DESC',$replaced_data=array()){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result;
			}

			$result = $this->select()
				->from('users')
				->join('status FORCE INDEX (PRIMARY)',"s_user_id=u_id")
				->join('photos FORCE INDEX (PRIMARY)',"p_user_id=u_id")
				->where($query_suffix);

			foreach($replaced_data as $key=>$value){
				$result->data($key,$value);
			}

			$result = $result->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();

			$this->cache->set($result);
			return $result;
		}

		public function getUserByID($user_id){
			$this->cache->key('users.items');

			if(($result = $this->cache->get()->array())){
				return $result;
			}

			$result = $this->select()
				->from('users')
				->join('status',"s_user_id=u_id")
				->join('photos',"p_user_id=u_id")
				->where("`u_id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result;
		}

		public function countUserNoticesById($receiver_id){
			$this->cache->key('notices.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(n_id) as total')
				->from('notice')
				->where("`n_receiver_id`='{$receiver_id}'")
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

















	}














