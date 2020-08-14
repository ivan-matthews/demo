<?php

	namespace Core\Controllers\Comments;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

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
			$this->cache->key('comments');
		}

		public function __destruct(){

		}

		public function countCommentsByItem($controller,$action,$item_id){
			$where_query = '`с_status`!=' . Kernel::STATUS_BLOCKED;
			$where_query .= " AND comments.`с_status`!=" . Kernel::STATUS_DELETED;;
			$where_query .= " AND `c_controller`=%controller%";
			if($action){
				$where_query .= " AND `c_action`=%action%";
			}
			$where_query .= " AND `c_item_id`=%item_id%";

			$result = $this->select('COUNT(c_id) as total')
				->from('comments')
				->where($where_query)
				->data('%controller%',$controller)
				->data('%action%',$action)
				->data('%item_id%',$item_id)
				->get()
				->itemAsArray();

			return $result['total'];
		}

		public function getCommentsByItem($controller,$action,$item_id,$limit,$offset){
			$where_query = 'comments.`с_status`!=' . Kernel::STATUS_BLOCKED;
			$where_query .= " AND comments.`с_status`!=" . Kernel::STATUS_DELETED;;
			$where_query .= " AND comments.`c_controller`=%controller%";
			if($action){
				$where_query .= " AND comments.`c_action`=%action%";
			}
			$where_query .= " AND comments.`c_item_id`=%item_id%";

			$result = $this->select(
				'comments.*',
				'a.u_full_name as author_name',
				'a.u_gender as author_gender',
				'a.u_log_type as author_log_type',
				'a.u_date_log as author_log_date',
				'ap.p_small as author_photo',
				'ap.p_date_updated as a_avatar_updated_date',
				'u.u_full_name as user_name',
				'u.u_gender as user_gender',
				'u.u_log_type as user_log_type',
				'u.u_date_log as user_log_date',
				'up.p_micro as user_photo',
				'up.p_date_updated as u_avatar_updated_date',
				'parent.c_content as parent_content'
			)
				->from('comments')
				->join('users as a FORCE INDEX(PRIMARY)',"a.u_id=c_author_id")
				->join('users as u FORCE INDEX(PRIMARY)',"u.u_id=c_receiver_id")
				->join('photos as ap FORCE INDEX(PRIMARY)',"a.u_avatar_id=ap.p_id")
				->join('photos as up FORCE INDEX(PRIMARY)',"u.u_avatar_id=up.p_id")
				->join('comments as parent FORCE INDEX(PRIMARY)',"comments.c_parent_id=parent.c_id")
				->where($where_query)
				->data('%controller%',$controller)
				->data('%action%',$action)
				->data('%item_id%',$item_id)
				->limit($limit)
				->offset($offset)
				->order('c_id')
				->sort('DESC')
				->get()
				->allAsArray();

			return $result;
		}


















	}














