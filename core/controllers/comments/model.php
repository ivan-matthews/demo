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

		protected $result;

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
			$where_query = '`c_status` = ' . Kernel::STATUS_ACTIVE;
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
			$where_query = 'comments.`c_status` = ' . Kernel::STATUS_ACTIVE;
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
				'parent.c_content as parent_content',
				'parent.c_date_created as parent_date'
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

		public function getLastComments($limit,$offset){
			$where_query = 'comments.`c_status` = ' . Kernel::STATUS_ACTIVE;

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
				'up.p_small as user_photo',
				'up.p_date_updated as u_avatar_updated_date',
				'parent.c_content as parent_content',
				'parent.c_date_created as parent_date'
			)
				->from('comments')
				->join('users as a FORCE INDEX(PRIMARY)',"a.u_id=c_author_id")
				->join('users as u FORCE INDEX(PRIMARY)',"u.u_id=c_receiver_id")
				->join('photos as ap FORCE INDEX(PRIMARY)',"a.u_avatar_id=ap.p_id")
				->join('photos as up FORCE INDEX(PRIMARY)',"u.u_avatar_id=up.p_id")
				->join('comments as parent FORCE INDEX(PRIMARY)',"comments.c_parent_id=parent.c_id")
				->where($where_query)
				->limit($limit)
				->offset($offset)
				->order('c_id')
				->sort('DESC')
				->get()
				->allAsArray();

			return $result;
		}

		public function addComment($controller,$action,$item_id,$author_id,$content,$attachments){
			$result = $this->insert('comments')
				->value('c_controller',$controller)
				->value('c_action',$action)
				->value('c_item_id',$item_id)
				->value('c_author_id',$author_id)
				->value('c_content',$content)
				->value('c_attachments_ids',$attachments)
				->value('c_date_created',time())
				->get()
				->id();

			return $result;
		}

		public function addParentComment($controller,$action,$item_id,$author_id,$parent_id,$receiver_id,$content,$attachments){
			$result = $this->insert('comments')
				->value('c_controller',$controller)
				->value('c_action',$action)
				->value('c_item_id',$item_id)
				->value('c_author_id',$author_id)
				->value('c_parent_id',$parent_id)
				->value('c_receiver_id',$receiver_id)
				->value('c_content',$content)
				->value('c_attachments_ids',$attachments)
				->value('c_date_created',time())
				->get()
				->id();

			return $result;
		}

		public function updateTotalComments($table,$field_name_key,$id_name_key,$item_id,$value){
			$result = $this->update($table)
				->query($field_name_key,$value)
				->where("`{$id_name_key}`=%item_id%")
				->data('%item_id%',$item_id)
				->get()
				->rows();

			return $result;
		}

		public function deleteComment($comment_id){
			$result = $this->update('comments')
				->field('c_status',Kernel::STATUS_DELETED)
				->field('c_date_deleted',time())
				->where("`c_id`=%comment_id%")
				->data('%comment_id%',$comment_id)
				->get()
				->rows();

			return $result;
		}

		public function getCommentById($comment_id){
			$result = $this->select()
				->from('comments')
				->where("`c_id`=%comment_id%")
				->data('%comment_id%',$comment_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function getLastCommentatorsIDs($controller,$action,$item_id,$author_id,$receiver_id,$limit){
			$where_query = "c_status !=" . Kernel::STATUS_DELETED;
			$where_query .= " AND c_author_id != %author_id%";
			$where_query .= " AND c_author_id != %receiver_id%";
			$where_query .= " AND c_controller = %controller%";
			$where_query .= " AND c_action = %action%";
			$where_query .= " AND c_item_id = %item_id%";

			$result = $this->select('DISTINCT c_author_id,c_id')
				->from('comments')
				->where($where_query)
				->data('%author_id%',$author_id)
				->data('%controller%',$controller)
				->data('%action%',$action)
				->data('%item_id%',$item_id)
				->data('%receiver_id%',$receiver_id)
				->order('c_id')
				->sort('DESC')
				->limit($limit)
				->get()
				->allAsArray();

			return $result;
		}

		public function getLastCommentatorsIDsForReplyAction($controller,$action,$item_id,$author_id,$receiver_id,$content_author,$limit){
			$where_query = "c_status !=" . Kernel::STATUS_DELETED;
			$where_query .= " AND c_author_id != %author_id%";
			$where_query .= " AND c_author_id != %receiver_id%";
			$where_query .= " AND c_author_id != %content_author%";
			$where_query .= " AND c_controller = %controller%";
			$where_query .= " AND c_action = %action%";
			$where_query .= " AND c_item_id = %item_id%";

			$result = $this->select('DISTINCT c_author_id,c_id')
				->from('comments')
				->where($where_query)
				->data('%author_id%',$author_id)
				->data('%controller%',$controller)
				->data('%action%',$action)
				->data('%item_id%',$item_id)
				->data('%receiver_id%',$receiver_id)
				->data('%content_author%',$content_author)
				->order('c_id')
				->sort('DESC')
				->limit($limit)
				->get()
				->allAsArray();

			return $result;
		}

		public function updateCommentContent($comment_id,$comment_content,$attachments){
			$result = $this->update('comments')
				->field('c_content',$comment_content)
				->field('c_attachments_ids',$attachments)
				->field('c_date_updated',time())
				->where("`c_id`=%comment_id%")
				->data('%comment_id%',$comment_id)
				->get()
				->rows();

			return $result;
		}

		public function countFind($search_query){
			$where_query = "c_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (c_content LIKE %search_query%";
				$where_query .= ")";
			}

			$this->result = $this->select('COUNT(c_id) as total')
				->from('comments')
				->join('users FORCE INDEX(PRIMARY)',"c_author_id = u_id")
				->where($where_query)
				->data('%search_query%',"%{$search_query}%")
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function find($search_query,$limit,$offset){
			$where_query = "c_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (c_content LIKE %search_query%";
				$where_query .= ")";
			}

			$order = "length(replace(u_full_name,%search_query%,%search_query%))";

			$this->result = $this->select(
				'p_small as image',
				'u_full_name as title',
				'c_content as description',
				'c_id as id',
				'p_date_updated as img_date',
				'u_gender as gender',
				'c_date_created as date',
				'c_controller as controller',
				'c_action as action',
				'c_item_id as item'
			)
				->from('comments')
				->join('users FORCE INDEX(PRIMARY)',"c_author_id = u_id")
				->join('photos FORCE INDEX(PRIMARY)',"u_avatar_id = p_id")
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














