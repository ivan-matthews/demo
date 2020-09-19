<?php

	namespace Core\Controllers\Attachments;

	use Core\Classes\Kernel;
	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

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
			$this->cache->key('attachments');
		}

		public function __destruct(){

		}

		public function getAttachments($controller,$action,$item_id){
			$this->result = $this->select()
				->from('attachments')
				->where("at_controller = %controller% AND at_action = %action% AND at_item_id = %item_id% AND at_status = " . Kernel::STATUS_ACTIVE)
				->data('%controller%',$controller)
				->data('%action%',$action)
				->data('%item_id%',$item_id)
				->order('at_id')
				->sort('ASC')
				->get()
				->allAsArray();

			return $this->result;
		}

		public function getPhotosAttachments(array $ids_list, $user_id){
			$data = array();
			$query = '';
			if($user_id){
				$query = "p_user_id = %user_id% AND ";
				$data['%user_id%'] = $user_id;
			}
			$query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$select_query = " AND (";
			foreach($ids_list as $key=>$item){
				$select_query .= "p_id = %item_{$key}% OR ";
				$data["%item_{$key}%"] = $item;
			}
			$select_query = rtrim($select_query," OR ");
			$query .= "{$select_query})";

			$this->result = $this->select()
				->from('photos')
				->where($query)
				->prepare($data)
				->get()
				->allAsArray();
			return $this->result;
		}

		public function getVideosAttachments(array $ids_list, $user_id){
			$data = array();
			$query = '';
			if($user_id){
				$query = "v_user_id = %user_id% AND ";
				$data['%user_id%'] = $user_id;
			}
			$query .= "v_status = " . Kernel::STATUS_ACTIVE;
			$select_query = " AND (";
			foreach($ids_list as $key=>$item){
				$select_query .= "v_id = %item_{$key}% OR ";
				$data["%item_{$key}%"] = $item;
			}
			$select_query = rtrim($select_query," OR ");
			$query .= "{$select_query})";

			$this->result = $this->select()
				->from('videos')
				->where($query)
				->prepare($data)
				->get()
				->allAsArray();
			return $this->result;
		}

		public function getAudiosAttachments(array $ids_list, $user_id){
			$data = array();
			$query = '';
			if($user_id){
				$query = "au_user_id = %user_id% AND ";
				$data['%user_id%'] = $user_id;
			}
			$query .= "au_status = " . Kernel::STATUS_ACTIVE;
			$select_query = " AND (";
			foreach($ids_list as $key=>$item){
				$select_query .= "au_id = %item_{$key}% OR ";
				$data["%item_{$key}%"] = $item;
			}
			$select_query = rtrim($select_query," OR ");
			$query .= "{$select_query})";

			$this->result = $this->select()
				->from('audios')
				->where($query)
				->prepare($data)
				->get()
				->allAsArray();
			return $this->result;
		}

		public function getFilesAttachments(array $ids_list, $user_id){
			$data = array();
			$query = '';
			if($user_id){
				$query = "f_user_id = %user_id% AND ";
				$data['%user_id%'] = $user_id;
			}
			$query .= "f_status = " . Kernel::STATUS_ACTIVE;
			$select_query = " AND (";
			foreach($ids_list as $key=>$item){
				$select_query .= "f_id = %item_{$key}% OR ";
				$data["%item_{$key}%"] = $item;
			}
			$select_query = rtrim($select_query," OR ");
			$query .= "{$select_query})";

			$this->result = $this->select()
				->from('files')
				->where($query)
				->prepare($data)
				->get()
				->allAsArray();
			return $this->result;
		}
















	}














