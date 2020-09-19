<?php

	namespace Core\Controllers\Photos;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		private $result;

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
			$this->cache->key('photos');
		}

		public function __destruct(){

		}

		public function countPhotos($query){
			$this->result = $this->select('COUNT(p_id) as total')
				->from('photos')
				->where($query)
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function getPhotos($limit,$offset,$query,$order,$sort){
			$this->result = $this->select()
				->from('photos')
				->where($query)
				->order($order)
				->sort($sort)
				->limit($limit)
				->offset($offset)
				->get()
				->allAsArray();
			return $this->result;
		}

		public function getPhotoById($photo_id,$query){
			$this->result = $this->select()
				->from('photos')
				->where("{$query} AND p_id = %photo_id%")
				->join('users',"u_id=p_user_id")
				->data('%photo_id%',$photo_id)
				->get()
				->itemAsArray();
			return $this->result;
		}

















	}














