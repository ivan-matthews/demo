<?php

	namespace Core\Controllers\Users;

	use Core\Classes\Kernel;
	use Core\Classes\Mail\Notice;
	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

	class Model extends ParentModel{

		public $users_index_fields = array(
			'SQL_CACHE u_date_log',
			'u_id',
			'u_full_name',
			'p_small',
			'p_date_updated',
			'u_gender',
			'u_log_type',
		);

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
		}

		public function countAllUsers($query_suffix=null,$replaced_data=array()){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(u_id) as total')->from('users')
				->where($query_suffix);

			foreach($replaced_data as $key=>$value){
				$result->data($key,$value);
			}

			$result = $result->get()->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

		public function getAllUsers($limit=15,$offset=0,$query_suffix=null,$order='u_date_created',$sort='DESC',$replaced_data=array()){
			$this->cache->key('users.all');

			if(($result = $this->cache->get()->array())){
				return $result;
			}

			$result = $this->select(...$this->users_index_fields)
				->from('users')
//				->join('status FORCE INDEX (PRIMARY)',"u_id=s_user_id")					// зачем ???
				->join('photos FORCE INDEX (PRIMARY)',"p_id=u_avatar_id")
				->join('geo_cities FORCE INDEX (PRIMARY)',"u_city_id=gc_city_id")
				->join('geo_countries FORCE INDEX (PRIMARY)',"u_country_id=g_country_id")
				->join('geo_regions FORCE INDEX (PRIMARY)',"gc_region_id=gr_region_id")
				->where($query_suffix);

			foreach($replaced_data as $key=>$value){
				$result->data($key,$value);
			}

			$result = $result->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();

			$this->cache->set($result);
			return $result;
		}

		public function getUserGroupsByGroupsArray(array $groups){
			$this->cache->key("users.groups");

			if(($result = $this->cache->get()->array())){
				return $result;
			}
			$where = '';
			foreach($groups as $group){
				$where .= "`ug_id`='{$group}' OR ";
			}
			$where = rtrim($where,"OR ");

			$result = $this->select()
				->from('user_groups')
				->where($where)
				->get()
				->allAsArray();

			$this->cache->set($result);
			return $result;
		}

		public function getUserByID($user_id){
			$this->cache->key("users.items.{$user_id}");

			if(($result = $this->cache->get()->array())){
				return $result;
			}

			$result = $this->select(
				"users.*","auth.a_groups","status.*","photos.*","geo_cities.*","geo_countries.*","geo_regions.*"
			)
				->from('users')
				->join('auth FORCE INDEX (PRIMARY)',"a_id=u_auth_id")
				->join('status FORCE INDEX (PRIMARY)',"u_status_id=s_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->join('geo_cities FORCE INDEX (PRIMARY)',"u_city_id=gc_city_id")
				->join('geo_countries FORCE INDEX (PRIMARY)',"u_country_id=g_country_id")
				->join('geo_regions FORCE INDEX (PRIMARY)',"gc_region_id=gr_region_id")
				->where("`u_id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result;
		}

		public function countUserNoticesById($receiver_id){
			$this->cache->key('notices.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(n_id) as total')
				->from('notice')
				->where("`n_receiver_id`='{$receiver_id}' AND `n_status`=" . Notice::STATUS_UNREAD)
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

/*
		public function countUserMessagesById($receiver_id){
			$this->cache->key('messages.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select('COUNT(m_id) as total')
				->from('messages')
				->join('messages_contacts',"mc_last_message_id=m_id")
				->where("`m_receiver_id`='{$receiver_id}' AND isnull(m_readed)")
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}
*/

		public function countUserMessagesById($receiver_id){
			$this->cache->key('messages.all');

			if(($result = $this->cache->get()->array())){
				return $result['total'];
			}

			$result = $this->select("sum(if(mc_receiver_id={$receiver_id},mc_receiver_total,mc_sender_total)) as total")
				->from('messages_contacts')
				->where(
					"(`mc_receiver_id`='{$receiver_id}' or `mc_sender_id`='{$receiver_id}')" .
					" and if(`mc_receiver_id`='{$receiver_id}',isnull(mc_hide_in_user),isnull(mc_hide_in_sender))"
				)
				->get()
				->itemAsArray();

			$this->cache->set($result);
			return $result['total'];
		}

		public function updateUserInfoByUserId(array $fields_list, array $compare_fields, $user_id){
			$update_query = $this->update('users');
			$data_to_update = null;
			foreach($compare_fields as $compare_field){
				if(!isset($fields_list[$compare_field['field']])){ continue; }
				$data_to_update = true;
				$update_query = $update_query->field(
					$compare_field['field'],
					$fields_list[$compare_field['field']]['attributes']['value']
				);
			}
			if($data_to_update){
				$update_query = $update_query->where("`u_id`=%user_id%");
				$update_query = $update_query->data('%user_id%',$user_id);
				$update_query = $update_query->get();
				$update_query = $update_query->rows();

				$this->cache->key("users.items.{$user_id}")->clear();
				$this->cache->key('users.all')->clear();

				return $update_query;
			}
			return false;
		}

		public function updateAvatarId($user_id,$avatar_id){

			$update_result = $this->update('users')
				->field('u_avatar_id',$avatar_id)
				->where("`u_id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $update_result;
		}

		public function updateStatusId($user_id,$status_id){

			$update_result = $this->update('users')
				->field('u_status_id',$status_id)
				->where("`u_id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $update_result;
		}













	}














