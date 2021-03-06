<?php

	namespace Core\Controllers\Status;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		public $status_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('status');
		}

		public function __destruct(){

		}

		public function addStatus(array $data_to_insert){

			$this->status_id = $this->insert('status')
				->value('s_user_id',$data_to_insert['s_user_id'])
				->value('s_status'	,$data_to_insert['s_status'])
				->value('s_content',$data_to_insert['s_content'])
				->value('s_date_created',$data_to_insert['s_date_created'])
				->get()
				->id();

			return $this->status_id;
		}

		public function editStatus(array $data_to_update,$status_id){

			$result = $this->update('status')
				->field('s_user_id',$data_to_update['s_user_id'])
				->field('s_status'	,$data_to_update['s_status'])
				->field('s_content',$data_to_update['s_content'])
				->field('s_date_updated',$data_to_update['s_date_updated'])
				->where("`s_user_id`=%user_id% AND `s_id`=%status_id%")
				->data('%status_id%',$status_id)
				->data('%user_id%',$data_to_update['s_user_id'])
				->get()
				->rows();

			return $result;
		}

		public function deleteStatus(array $data_to_delete,$status_id){

			$result = $this->update('status')
				->field('s_status',$data_to_delete['s_status'])
				->field('s_date_deleted',$data_to_delete['s_date_deleted'])
				->where("`s_user_id`=%user_id% AND `s_id`=%status_id%")
				->data('%status_id%',$status_id)
				->data('%user_id%',$data_to_delete['s_user_id'])
				->get()
				->rows();

			return $result;
		}

		public function getStatusItemById($status_id){

			$result = $this->select()
				->from('status')
				->where("`s_id`=%status_id%")
				->data('%status_id%',$status_id)
				->limit(1)
				->get()
				->itemAsArray();

			return $result;
		}















	}














