<?php

	namespace Core\Controllers\Photos;

	use Core\Classes\Kernel;
	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

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

		public function countPhotos($query,$prepared_data = array()){
			$this->result = $this->select('COUNT(p_id) as total')
				->from('photos')
				->where($query)
				->prepare($prepared_data)
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function getPhotos($limit,$offset,$query,$order,$sort,$prepared_data = array()){
			$this->result = $this->select()
				->from('photos')
				->where($query)
				->prepare($prepared_data)
				->order($order)
				->sort($sort)
				->limit($limit)
				->offset($offset)
				->get()
				->allAsArray();
			return $this->result;
		}

		public function getPhotoById($photo_id,$query){
			$this->result = $this->select(
				'photos.*',
				'users.*',
				'p.p_micro as micro',
				'p.p_date_updated as updated',
				'p.p_date_created as created'
			)
				->from('photos')
				->where("{$query} AND photos.p_id = %photo_id%")
				->join('users FORCE INDEX(PRIMARY)',"u_id=p_user_id")
				->join('photos as p FORCE INDEX(PRIMARY)',"u_avatar_id=p.p_id")
				->data('%photo_id%',$photo_id)
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function deletePhoto($user_id,$photo_id){
			$this->result = $this->update('photos')
				->field('p_status',Kernel::STATUS_DELETED)
				->field('p_date_deleted',time())
				->where("p_id = %photo_id% AND p_user_id = %user_id%")
				->data('%photo_id%',$photo_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function updatePhoto($user_id,$photo_id,$update_data){
			$this->result = $this->update('photos')
				->field('p_name',$update_data['p_name'])
				->field('p_description',$update_data['p_description'])
				->field('p_date_updated',time())
				->where("p_id = %photo_id% AND p_user_id = %user_id%")
				->data('%photo_id%',$photo_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function addPhotos(array $photos_multi_array){
			$insert = $this->insert('photos');
			$time = time();
			foreach($photos_multi_array as $photos){
				foreach($photos as $key=>$param){
					$insert = $insert->value($key,$param);
				}

				$insert = $insert->update('p_date_updated',$time);
				$insert = $insert->update('p_status',Kernel::STATUS_ACTIVE);
			}
			$insert = $insert->get();

			return $insert->id();
		}















	}














