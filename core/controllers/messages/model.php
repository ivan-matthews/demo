<?php

	namespace Core\Controllers\Messages;

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
			$this->cache->key('messages');
		}

		public function countContacts($user_id){
			$result = $this->select("COUNT(mc_id) as total")
				->from('messages_contacts')
				->where("`mc_user_id`=%user_id% AND `mc_status`!=" . Kernel::STATUS_DELETED)
				->data('%user_id%',$user_id)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getContacts($user_id,$limit,$offset){
			$result = $this->select(
				"messages_contacts.*",
				"users.*",
				"photos.*",
				"messages.*",
				"(select count(m_id) from messages where m_contact_id=mc_id and isnull(m_date_read) and m_status!=" . Kernel::STATUS_DELETED . ") as total"
			)
				->from('messages_contacts')
				->join('users FORCE INDEX(PRIMARY)',"u_id=mc_sender_id")
				->join('photos FORCE INDEX(PRIMARY)',"p_id=u_avatar_id")
				->join('messages FORCE INDEX(PRIMARY)',"m_id=mc_last_message_id")
				->where("`mc_user_id`=%user_id% AND `mc_status`!=" . Kernel::STATUS_DELETED)
				->data('%user_id%',$user_id)
				->limit($limit)
				->offset($offset)
				->order(/*'total DESC',*/'mc_last_message_id DESC')		// ??? total
				->sort(null)
				->get()
				->allAsArray();
			return $result;
		}

		public function getContactById($contact_id){
			$result = $this->select()
				->from('messages_contacts')
				->join('users FORCE INDEX(PRIMARY)',"u_id=mc_sender_id")
				->join('photos FORCE INDEX(PRIMARY)',"p_id=u_avatar_id")
				->where("`mc_id`=%contact_id% AND `mc_status`!=" . Kernel::STATUS_DELETED)
				->data('%contact_id%',$contact_id)
				->limit(1)
				->get()
				->itemAsArray();

			return $result;
		}

		public function countMessagesByContactId($user_id,$sender_id){
			$where_query = " `mc_status`!=" . Kernel::STATUS_DELETED;
			$where_query .= " AND m_status!=" . Kernel::STATUS_DELETED;
			$where_query .= " AND (";
			$where_query .= "(isnull(m_hide_in_user) AND mc_user_id=%user_id% and mc_sender_id=%sender_id%)";
			$where_query .= " OR ";
			$where_query .= "(isnull(m_hide_in_sender) AND mc_sender_id=%user_id% and mc_user_id=%sender_id%)";
			$where_query .= ")";

			$result = $this->select("COUNT(m_id) as total")
				->from('messages')
				->join('messages_contacts FORCE INDEX(PRIMARY)',"m_contact_id=mc_id")
				->where($where_query)
				->data('%user_id%',$user_id)
				->data('%sender_id%',$sender_id)
				->get()
				->itemAsArray();

			return $result['total'];
		}

		public function getMessagesByContactId($user_id,$sender_id,$limit,$offset){
			$where_query = " `mc_status`!=" . Kernel::STATUS_DELETED;
			$where_query .= " AND m_status!=" . Kernel::STATUS_DELETED;
			$where_query .= " AND (";
			$where_query .= "(isnull(m_hide_in_user) AND mc_user_id=%user_id% and mc_sender_id=%sender_id%)";
			$where_query .= " OR ";
			$where_query .= "(isnull(m_hide_in_sender) AND mc_sender_id=%user_id% and mc_user_id=%sender_id%)";
			$where_query .= ")";

			$result = $this->select()
				->from('messages')
				->join('messages_contacts FORCE INDEX(PRIMARY)',"m_contact_id=mc_id")
				->where($where_query)
				->data('%user_id%',$user_id)
				->data('%sender_id%',$sender_id)
				->limit($limit)
				->offset($offset)
				->order('m_id')
				->sort('DESC')
				->get()
				->allAsArray();

			return $result;
		}

		public function updateMessagesAsReadByIDs($update_messages_query_string){
			$result = $this->update('messages')
				->field('m_date_read',time())
				->where($update_messages_query_string)
				->get()
				->rows();
			return $result;
		}
/*
		update messages
 			left join messages_contacts
 				on m_contact_id=mc_id
 			set m_date_read=null,
					m_status=1,
					m_date_deleted=null,
					mc_status=1,
                    m_hide_in_user=null,
                    m_hide_in_sender=null
*/
		public function deleteContact($contact_id){
			$current_time = time();

			$result = $this->update('messages_contacts')
				->field('mc_status',Kernel::STATUS_DELETED)
				->field('mc_date_deleted',$current_time)
//				->field('m_status',Kernel::STATUS_DELETED)
//				->field('m_date_deleted',$current_time)
				->field('m_date_read',$current_time)
				->join('messages',"mc_id=m_contact_id")
				->where("`mc_id`=%contact_id%")
				->data('%contact_id%',$contact_id)
				->get()
				->rows();

			return $result;
		}

		public function hideSenderMessage($message_id){
			$current_time = time();

			$result = $this->update('messages')
//				->field('m_status',Kernel::STATUS_DELETED)
//				->field('m_date_deleted',$current_time)
				->field('m_hide_in_sender',true)
				->field('m_date_read',$current_time)
				->where("`m_id`=%message_id%")
				->data('%message_id%',$message_id)
				->get()
				->rows();

			return $result;
		}

		public function hideMyMessage($message_id){
			$current_time = time();

			$result = $this->update('messages')
				->field('m_hide_in_user',true)
				->field('m_date_read',$current_time)
				->where("`m_id`=%message_id%")
				->data('%message_id%',$message_id)
				->get()
				->rows();

			return $result;
		}

		public function hideOwnMessage($message_id){
			$current_time = time();

			$result = $this->update('messages')
				->field('m_hide_in_user',true)
				->field('m_hide_in_sender',true)
				->field('m_date_read',$current_time)
				->where("`m_id`=%message_id%")
				->data('%message_id%',$message_id)
				->get()
				->rows();

			return $result;
		}

		public function getMessageById($message_id){
			$result = $this->select()
				->from('messages')
				->join('messages_contacts',"m_contact_id=mc_id")
				->where("`m_id`=%message_id%")
				->data('%message_id%',$message_id)
				->get()
				->itemAsArray();

			return $result;
		}











	}














