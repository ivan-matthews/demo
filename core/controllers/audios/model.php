<?php

	namespace Core\Controllers\Audios;

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
			$this->cache->key('audios');
		}

		public function __destruct(){

		}

		public function countAudios($query,$prepared_data = array()){
			$this->result = $this->select('COUNT(au_id) as total')
				->from('audios')
				->where($query)
				->prepare($prepared_data)
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function getAudios($limit,$offset,$query,$order,$sort,$prepared_data = array()){
			$this->result = $this->select(
				'audios.*',
				'users.u_gender',
				'users.u_full_name',
				'photos.p_micro',
				'photos.p_date_updated'
			)
				->from('audios')
				->join('users FORCE INDEX(PRIMARY)','u_id = au_user_id')
				->join('photos FORCE INDEX(PRIMARY)','u_avatar_id = p_id')
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

		public function getAudioByID($audio_id){
			$this->result = $this->select()
				->from('audios')
				->where("au_id = %audio_id% AND au_status = " . Kernel::STATUS_ACTIVE)
				->data('%audio_id%',$audio_id)
				->join('users FORCE INDEX(PRIMARY)', "au_user_id = u_id")
				->join('photos FORCE INDEX(PRIMARY)',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function getUserAudioByID($user_id,$audio_id){
			$this->result = $this->select()
				->from('audios')
				->where("au_id = %audio_id% AND au_user_id = %user_id% AND au_status = " . Kernel::STATUS_ACTIVE)
				->data('%audio_id%',$audio_id)
				->data('%user_id%',$user_id)
//				->join('users FORCE INDEX(PRIMARY)', "au_user_id = u_id")
//				->join('photos FORCE INDEX(PRIMARY)',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function deleteAudio($user_id,$audio_id){
			$this->result = $this->update('audios')
				->field('au_status',Kernel::STATUS_DELETED)
				->field('au_date_deleted',time())
				->where("au_id = %audio_id% AND au_user_id = %user_id% AND au_status = " . Kernel::STATUS_ACTIVE)
				->data('%audio_id%',$audio_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function updateAudio($user_id,$audio_id,$update_data){
			$this->result = $this->update('audios')
				->field('au_name',$update_data['au_name'])
				->field('au_description',$update_data['au_description'])
				->field('au_date_updated',time())
				->where("au_id = %audio_id% AND au_user_id = %user_id%")
				->data('%audio_id%',$audio_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function addAudios(array $insert_data){
			$insert = $this->insert('audios');

			foreach($insert_data as $audio){
				$audio['au_name'] = fx_crop_file_name($audio['au_name'],64);
				foreach($audio as $key=>$value){
					$insert = $insert->value($key,$value);
				}
				$insert = $insert->update('au_date_updated',$audio['au_date_created']);
				$insert = $insert->update('au_status',Kernel::STATUS_ACTIVE);
			}
			return $insert->get()->id();
		}

		public function updateTotalViewsAudio($audio_id){
			$this->result = $this->update('audios')
				->query('au_total_views','au_total_views+1')
				->where("au_id = %audio_id%")
				->data('%audio_id%',$audio_id)
				->get()
				->rows();
			return $this->result;
		}

		public function countFind($search_query){
			$where_query = "au_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (au_name LIKE %search_query%";
				$where_query .= " OR au_description LIKE %search_query%";
				$where_query .= ")";
			}

			$this->result = $this->select('COUNT(au_id) as total')
				->from('audios')
				->join('users FORCE INDEX(PRIMARY)','u_id = au_user_id')
				->where($where_query)
				->data('%search_query%',"%{$search_query}%")
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function find($search_query,$limit,$offset){
			$where_query = "au_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (au_name LIKE %search_query%";
				$where_query .= " OR au_description LIKE %search_query%";
				$where_query .= ")";
			}

			$order = "length(replace(au_name,%search_query%,%search_query%))+";
			$order .= "length(replace(au_description,%search_query%,%search_query%))";

			$this->result = $this->select(
				'au_name as title',
				'au_description as description',
				'au_id as id',
				'au_date_created as date'
			)
				->from('audios')
				->join('users FORCE INDEX(PRIMARY)','u_id = au_user_id')
				->where($where_query)
				->limit($limit)
				->offset($offset)
				->data('%search_query%',"%{$search_query}%")
				->order($order)
				->sort('DESC')
				->get()
				->allAsArray();
			return $this->result;
		}














	}














