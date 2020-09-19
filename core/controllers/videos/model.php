<?php

	namespace Core\Controllers\Videos;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		private $result;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('videos');
		}

		public function __destruct(){

		}

		public function countVideos($query,$prepared_data = array()){
			$this->result = $this->select('COUNT(v_id) as total')
				->from('videos')
				->where($query)
				->prepare($prepared_data)
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function getVideos($limit,$offset,$query,$order,$sort,$prepared_data = array()){
			$this->result = $this->select(
				'videos.*',
				'users.u_gender',
				'users.u_full_name',
				'photos.p_micro',
				'photos.p_date_updated'
			)
				->from('videos')
				->join('users','u_id = v_user_id')
				->join('photos','u_avatar_id = p_id')
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

		public function getVideoByID($video_id){
			$this->result = $this->select()
				->from('videos')
				->where("v_id = %video_id% AND v_status = " . Kernel::STATUS_ACTIVE)
				->data('%video_id%',$video_id)
				->join('users', "v_user_id = u_id")
				->join('photos',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function getUserVideoByID($user_id,$video_id){
			$this->result = $this->select()
				->from('videos')
				->where("v_id = %video_id% AND v_user_id = %user_id% AND v_status = " . Kernel::STATUS_ACTIVE)
				->data('%video_id%',$video_id)
				->data('%user_id%',$user_id)
//				->join('users', "v_user_id = u_id")
//				->join('photos',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function deleteVideo($user_id,$video_id){
			$this->result = $this->update('videos')
				->field('v_status',Kernel::STATUS_DELETED)
				->field('v_date_deleted',time())
				->where("v_id = %video_id% AND v_user_id = %user_id% AND v_status = " . Kernel::STATUS_ACTIVE)
				->data('%video_id%',$video_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function updateVideo($user_id,$video_id,$update_data){
			$this->result = $this->update('videos')
				->field('v_name',$update_data['v_name'])
				->field('v_description',$update_data['v_description'])
				->field('v_date_updated',time())
				->where("v_id = %video_id% AND v_user_id = %user_id%")
				->data('%video_id%',$video_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function addVideos(array $insert_data){
			$insert = $this->insert('videos');

			foreach($insert_data as $video){
				$video['v_name'] = fx_crop_file_name($video['v_name'],64);
				foreach($video as $key=>$value){
					$insert = $insert->value($key,$value);
				}
				$insert = $insert->update('v_date_updated',$video['v_date_created']);
				$insert = $insert->update('v_status',Kernel::STATUS_ACTIVE);
			}
			return $insert->get()->id();
		}

		public function updateTotalViewsVideo($video_id){
			$this->result = $this->update('videos')
				->query('v_total_views','v_total_views+1')
				->where("v_id = %video_id%")
				->data('%video_id%',$video_id)
				->get()
				->rows();
			return $this->result;
		}














	}














