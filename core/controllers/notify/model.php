<?php

	namespace Core\Controllers\Notify;

	use Core\Classes\Mail\Notice;
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
			$this->cache->key('notify');
		}

		public function countNotices($user_id,$query){
			$result = $this->select("COUNT(n_id) as total")
				->from('notice')
				->where("`n_receiver_id`=%user_id% AND {$query}")
				->data('%user_id%',$user_id)
				->get()
				->itemAsArray();

			return $result['total'];
		}

		public function getNotices($user_id,$query,$limit,$offset){
			$result = $this->select()
				->from('notice')
				->join('users FORCE INDEX(PRIMARY)',"n_sender_id=u_id")
				->join('photos FORCE INDEX(PRIMARY)',"p_id=u_avatar_id")
				->where("`n_receiver_id`=%user_id% AND {$query}")
				->data('%user_id%',$user_id)
				->limit($limit)
				->offset($offset)
				->order('n_status ASC, n_id DESC')
				->sort(null)
				->get()
				->allAsArray();

			return $result;
		}

		public function getNoticeById($notice_id){
			$notice_data = $this->select()
				->from('notice')
				->where("`n_id`=%notice_id%")
				->data('%notice_id%',$notice_id)
				->get()
				->itemAsArray();
			return $notice_data;
		}

		public function readNotice($notice_id){
			$result = $this->update('notice')
				->field('n_status',Notice::STATUS_READED)
				->field('n_date_updated',time())
				->field('n_unique_count',0)
				->where("`n_id`=%notice_id%")
				->data('%notice_id%',$notice_id)
				->get()
				->rows();
			return $result;
		}

		public function deleteNotice($notice_id){
			$result = $this->update('notice')
				->field('n_status',Notice::STATUS_DELETED)
				->field('n_date_deleted',time())
				->field('n_unique_count',0)
				->where("`n_id`=%notice_id%")
				->data('%notice_id%',$notice_id)
				->get()
				->rows();
			return $result;
		}

		public function readAllNotices($user_id){
			$result = $this->update('notice')
				->field('n_status',Notice::STATUS_READED)
				->field('n_date_updated',time())
				->field('n_unique_count',0)
				->where("`n_receiver_id`=%notice_id% AND `n_status`=" . Notice::STATUS_UNREAD)
				->data('%notice_id%',$user_id)
				->get()
				->rows();
			return $result;
		}

		public function deleteAllNotices($user_id){
			$result = $this->update('notice')
				->field('n_status',Notice::STATUS_DELETED)
				->field('n_date_deleted',time())
				->field('n_unique_count',0)
				->where("`n_receiver_id`=%notice_id%")
				->data('%notice_id%',$user_id)
				->get()
				->rows();
			return $result;
		}

















	}














