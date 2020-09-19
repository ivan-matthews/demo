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
			$this->result = $this->select('COUNT(f_id) as total');
			$this->result = $this->result->from('files');
			$this->result = $this->result->where($query);
			if($prepared_data){
				foreach($prepared_data as $key=>$value){
					$this->result = $this->result->data($key,$value);
				}
			}
			$this->result = $this->result->get();
			$this->result = $this->result->itemAsArray();
			return $this->result['total'];
		}

		public function getFiles($limit,$offset,$query,$order,$sort,$prepared_data = array()){
			$this->result = $this->select();
			$this->result = $this->result->from('files');
			$this->result = $this->result->join('users','u_id = f_user_id');
			$this->result = $this->result->join('photos','u_avatar_id = p_id');
			$this->result = $this->result->where($query);
			if($prepared_data){
				foreach($prepared_data as $key=>$value){
					$this->result = $this->result->data($key,$value);
				}
			}
			$this->result = $this->result->order($order);
			$this->result = $this->result->sort($sort);
			$this->result = $this->result->limit($limit);
			$this->result = $this->result->offset($offset);
			$this->result = $this->result->get();
			$this->result = $this->result->allAsArray();
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

			foreach($insert_data as $data){
				foreach($data as $key=>$value){
					$insert = $insert->value($key,$value);
				}
				$insert = $insert->update('f_date_updated',$data['f_date_created']);
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














