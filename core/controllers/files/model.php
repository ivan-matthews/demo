<?php

	namespace Core\Controllers\Files;

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
			$this->cache->key('files');
		}

		public function __destruct(){

		}

		public function countFiles($query,$prepared_data = array()){
			$this->result = $this->select('COUNT(f_id) as total')
				->from('files')
				->where($query)
				->prepare($prepared_data)
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function getFiles($limit,$offset,$query,$order,$sort,$prepared_data = array()){
			$this->result = $this->select(
				'files.*',
				'users.u_gender',
				'users.u_full_name',
				'photos.p_micro',
				'photos.p_date_updated'
			)
				->from('files')
				->join('users','u_id = f_user_id')
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

		public function getFileByID($file_id){
			$this->result = $this->select()
				->from('files')
				->where("f_id = %file_id% AND f_status = " . Kernel::STATUS_ACTIVE)
				->data('%file_id%',$file_id)
				->join('users', "f_user_id = u_id")
				->join('photos',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function getUserFileByID($user_id,$file_id){
			$this->result = $this->select()
				->from('files')
				->where("f_id = %file_id% AND f_user_id = %user_id% AND f_status = " . Kernel::STATUS_ACTIVE)
				->data('%file_id%',$file_id)
				->data('%user_id%',$user_id)
//				->join('users', "f_user_id = u_id")
//				->join('photos',"u_avatar_id = p_id")
				->get()
				->itemAsArray();
			return $this->result;
		}

		public function deleteFile($user_id,$file_id){
			$this->result = $this->update('files')
				->field('f_status',Kernel::STATUS_DELETED)
				->field('f_date_deleted',time())
				->where("f_id = %file_id% AND f_user_id = %user_id% AND f_status = " . Kernel::STATUS_ACTIVE)
				->data('%file_id%',$file_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function updateFile($user_id,$file_id,$update_data){
			$this->result = $this->update('files')
				->field('f_name',$update_data['f_name'])
				->field('f_description',$update_data['f_description'])
				->field('f_date_updated',time())
				->where("f_id = %file_id% AND f_user_id = %user_id%")
				->data('%file_id%',$file_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this->result;
		}

		public function addFiles(array $insert_data){
			$insert = $this->insert('files');

			foreach($insert_data as $file){
				$file['f_name'] = fx_crop_file_name($file['f_name'],64);
				foreach($file as $key=>$value){
					$insert = $insert->value($key,$value);
				}
				$insert = $insert->update('f_date_updated',$file['f_date_created']);
				$insert = $insert->update('f_status',Kernel::STATUS_ACTIVE);
			}
			return $insert->get()->id();
		}

		public function updateTotalViewsFile($file_id){
			$this->result = $this->update('files')
				->query('f_total_views','f_total_views+1')
				->where("f_id = %file_id%")
				->data('%file_id%',$file_id)
				->get()
				->rows();
			return $this->result;
		}














	}














